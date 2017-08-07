<?php

namespace App\Http\Controllers;


use App\LoginToken;
use App\Notificacion;
use App\Region;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class NotificacionesController extends Controller {

    /**
     * Notificación: Index
     * Método para cargar la vista principal de notificaciones.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $regiones = Region::all();
        $notificaciones = Notificacion::orderBy('fecha_emision', 'desc')->paginate(15);
        return view('notificaciones.index', array('notificaciones' => $notificaciones, 'regiones' => $regiones));
    }


    /**
     * Notificación: Enviar
     * Método que manipula el envío de las notificaciones a partir de lo enviado en el formulario, la notificación se
     * configura y se realiza el filtro necesario para saber a qué usuarios les llegará.
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function enviar(Request $request) {

        //Campos recibidos en el request.
        $titulo = $request->input('titulo');
        $mensaje = $request->input('mensaje');
        $enlace = $request->input('enlace');
        $hombre = $request->input('chk_hombre');
        $mujer = $request->input('chk_mujer');
        $rango = $request->input('sl_rango_edad');
        $age1 = $request->input('txt_age1');
        $age2 = $request->input('txt_age2');
        $android = $request->input('chk_android');
        $ios = $request->input('chk_ios');
        $regiones = $request->input('sl_region');

        $idGenero = null;

        //Se prepara una consulta con los joins necesarios en bd
        $tokens = LoginToken::query()->join('usuario', 'id_usuario','usuario.id')
            ->join('datos_usuario', 'id', 'datos_usuario.id_usuario')
            ->join('municipio', 'datos_usuario.id_municipio', 'municipio.id_municipio');


        /*
         * Filtros por sistema operativo, sexo, edad y región.
         */
        if($android != "android") {
            $tokens = $tokens->where('os', '!=', 'android');
        }
        if($ios != "ios") {
            $tokens = $tokens->where('os', '!=', 'ios');
        }
        if($hombre != "hombre") {
            $idGenero = 2;
            $tokens = $tokens
                ->where('id_genero', '!=', 1);
        }
        if($mujer != "mujer") {
            $idGenero = 1;
            $tokens = $tokens
                ->where('id_genero', '!=', 2);
        }

        //Lógica para la aplicación del filtro por región.
        $tokens->where(function($query) use ($regiones){
            foreach ($regiones as $region) {
                $query->orWhere('municipio.id_region', $region);
            }
            return $query;
        });


        //Lógica para la aplicación del filtro por edad.
        $mayor = Carbon::now('America/Mexico_City');
        $menor = Carbon::now('America/Mexico_City');
        switch ($rango) {
            case 2:
                $mayor->year = $mayor->year - $age1;
                $menor->year = $menor->year - $age2;

                $tokens = $tokens->where('fecha_nacimiento', '<', $mayor )
                    ->where('fecha_nacimiento', '>', $menor);
                break;
            case 3:
                $mayor->year = $mayor->year - $age1;
                $tokens = $tokens->where('fecha_nacimiento', '<', $mayor );
                break;
            case 4:
                $menor->year = $menor->year - $age2;
                $tokens = $tokens->where('fecha_nacimiento', '>', $menor);
                break;

        }

        //Se clonan los tokens para separar el envío en iOS y Android.
        $tokens1 = clone $tokens;
        $tokens2 = clone $tokens;

        $tokensAndroid = $tokens1->select('device_token')
            ->where('os', 'android')
            ->pluck('device_token')->toArray();
        $tokensIOS = $tokens2->select('device_token')
            ->where('os', 'ios')
            ->pluck('device_token')->toArray();


        //Generación del mensaje.
        $message = array(
            'title' => $titulo,
            'body' => $mensaje,
            'link_url' => $enlace,
            'sound' => 'default',
            'priority' => 'high',
            'category' => 'URL_CATEGORY',
            'tag' => $enlace);

        //Envío de las notificaciones a iOS y Android
        //dd($tokensIOS);
        $message_status = $this->sendNotification($tokensIOS, $message, 'notification');
        $message_status2 = $this->sendNotification($tokensAndroid, $message, 'data');

        //Condición que se cumple si fueron enviados los mensajes.
        if(isset($message_status) && isset($message_status2)){
            $notificacion = Notificacion::create(array(
                "titulo" => $titulo,
                "mensaje" => $mensaje,
                "fecha_emision" => Carbon::now('America/Mexico_City'),
                "edad_minima" => $age1,
                "edad_maxima" => $age2,
                "id_genero" => $idGenero,
                "url" => $enlace
            ));
            $idsUsuario = $tokens->select('id')
                ->pluck('id')->toArray();

            $notificacion->usuarios()->sync($idsUsuario);

        }

        return redirect()->back()->with('messages', 'La notificación fue enviada exitosamente');
    }


    /**
     * Notificación: SendNotification
     * Método final que realiza el envío de la notificación a partir de la generación de un mensaje y la selección
     * de tokens a los que se realizará el envío.
     * @param $tokens
     * @param $message
     * @param $type
     * @return mixed
     */
    function sendNotification($tokens, $message, $type){
        $url = "https://fcm.googleapis.com/fcm/send";
        $fields = array(
            'registration_ids' => $tokens,
            $type => $message,
            'priority' => 'high',
            'content_available' => true, );

        //Se configura la llave de Firebase.
        $headers = array(
          //  'Authorization:key = AIzaSyDKAbShlitmin_wsoxRxHLmdi7Ieynn3cY ',
          'Authorization:key = AIzaSyAfE_UZYPU8GFrx-5Ci_HZ3hpBzh_JMSPE ',


            'Content-Type:application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if($result === FALSE){
            die('Curl failed ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;

    }

    /**
     * Notificación: Eliminar
     * Método que permite la eliminación de un listado de notificaciones a partir de un arreglo de ids.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function eliminar(Request $request) {
        $ids = \GuzzleHttp\json_decode($request->input('id-eliminar'));
        foreach ($ids as $id) {
            $notificacion = Notificacion::find($id);
            $notificacion->delete();
        }
        return redirect('/notificaciones');
    }


    /**
     * Notificación: Renderizar lista
     * Muestra la lista de notificaciones para la parte web con su sección de paginado para cambiar de página por AJAX.
     * @param Request $request
     * @return mixed
     */
    public function lista(Request $request) {
        $notificaciones = Notificacion::paginate(15);
        return View::make('notificaciones.lista')->with('notificaciones', $notificaciones)->render();
    }
}
