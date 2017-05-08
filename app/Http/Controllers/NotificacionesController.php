<?php

namespace App\Http\Controllers;


use App\LoginToken;
use App\Notificacion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificacionesController {

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        return view('notificaciones.index');
    }




    public function enviar(Request $request) {

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

        $idGenero = null;


        $tokens = LoginToken::query()->join('usuario', 'id_usuario','usuario.id')->join('datos_usuario', 'id', 'datos_usuario.id_usuario');

        if($android != "true") {
            $tokens = $tokens->where('os', '!=', 'android');
        }
        if($ios != "true") {
            $tokens = $tokens->where('os', '!=', 'ios');
        }
        if($hombre != "true") {
            $idGenero = 2;
            $tokens = $tokens
                ->where('id_genero', '!=', 1);
        }
        if($mujer != "true") {
            $idGenero = 1;
            $tokens = $tokens
                ->where('id_genero', '!=', 2);
        }

        $mayor = Carbon::now('America/Mexico_City');
        $menor = Carbon::now('America/Mexico_City');
        switch ($rango) {
            case 1:
                $mayor->year = $mayor->year - $age1;
                $menor->year = $menor->year - $age2;

                $tokens = $tokens->where('fecha_nacimiento', '<', $mayor )
                    ->where('fecha_nacimiento', '>', $menor);
                break;
            case 2:
                $mayor->year = $mayor->year - $age1;
                $tokens = $tokens->where('fecha_nacimiento', '<', $mayor );
                break;
            case 3:
                $menor->year = $menor->year - $age2;
                $tokens = $tokens->where('fecha_nacimiento', '>', $menor);
                break;

        }

        $tokens1 = clone $tokens;
        $tokens2 = clone $tokens;

        $tokensAndroid = $tokens->select('device_token')
            ->where('os', 'android')
            ->pluck('device_token')->toArray();
        $tokensIOS = $tokens2->select('device_token')
            ->where('os', 'ios')
            ->pluck('device_token')->toArray();


        $message = array(
            'title' => $titulo,
            'body' => $mensaje,
            'link_url' => $enlace,
            'sound' => 'default',
            'priority' => 'high',
            'category' => 'URL_CATEGORY',
            'tag' => $enlace);

        $message_status = $this->sendNotification($tokensIOS, $message, 'notification');
        $message_status2 = $this->sendNotification($tokensAndroid, $message, 'data');
        if(isset($message_status) && isset($message_status2)){
            $success = array("success" => "true");
            Notificacion::create(array(
                "titulo" => $titulo,
                "mensaje" => $mensaje,
                "fecha_emision" => Carbon::now('America/Mexico_City'),
                "edad_minima" => $age1,
                "edad_maxima" => $age2,
                "id_genero" => $idGenero,
                "url" => $enlace
            ));
        }
        return redirect('/notificaciones');

    }


    function sendNotification($tokens, $message, $type){
        $url = "https://fcm.googleapis.com/fcm/send";
        $fields = array(
            'registration_ids' => $tokens,
            $type => $message,
            'priority' => 'high',
            'content_available' => true, );

        $headers = array(
            'Authorization:key = AIzaSyBqcgu3wsKmTDKHQjpMhhj-gie-eLR_ELI ',
            'Content-Type: application/json'
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
}
