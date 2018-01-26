<?php

namespace App\Http\Controllers;

use App\CodigoGuanajoven;
use App\DatosUsuario;
use App\Evento;
use Auth;
use App\UsuarioEvento;
use App\Notifications\EventoNotificacion;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class EventoApiController extends Controller
{

    /**
     * Eventos: Obtener
     * Devuelve la lista de eventos activos.
     */
    public function obtenerEventos(Request $request)
    {
        $timestamp = $request->input('timestamp');
        $eventos = Evento::where('updated_at', '>', $timestamp)
            ->orderBy('created_at')
            ->withTrashed()
            ->get();

        return response()->json(array(
            'status' => 200,
            'success' => true,
            'errors' => [],
            'data' => $eventos
        ));
    }

    /**
     * Evento: Marcar
     * params: [id_evento, api_token, latitud, longitud]
     * Método para indicar que a un usuario está en el área de un evento.
     */
    public function marcarEvento(Request $request) {
        $idEvento = $request->input('id_evento');
        $apiToken = $request->input('api_token');
        $latitudUsuario = $request->input('latitud');
        $longitudUsuario = $request->input('longitud');

        $evento = Evento::find($idEvento);
        $latitudEvento = $evento->latitud;
        $longitudEvento = $evento->longitud;
        $usuario = User::where('api_token', $apiToken)->first();

        $radioTierra = 6378.137;
        $degrees = pi() / 180;

        $latitudUsuario = $latitudUsuario * $degrees;
        $longitudUsuario = $longitudUsuario * $degrees;
        $latitudEvento = $latitudEvento * $degrees;
        $longitudEvento = $longitudEvento * $degrees;

        $distanciaLongitud = $longitudUsuario - $longitudEvento;

        $distanciaTotal = acos(sin($latitudEvento) * sin($latitudUsuario) + cos($latitudEvento) *
                cos($latitudUsuario) * cos($distanciaLongitud)) * $radioTierra;

        $distanciaMetros = $distanciaTotal * 1000;

        if ($distanciaMetros <= 500) {
            if (UsuarioEvento::where('id_evento', '=', $idEvento)->where('id_usuario', '=', $usuario->id)->where('asistio', '=', 1)->count() == 0) {
                $notificacion = UsuarioEvento::where('id_evento', $idEvento)->where('id_usuario', $usuario->id)->first();

                if ($notificacion == null) {
                    $registro = new UsuarioEvento();
                    $registro->id_usuario = $usuario->id;
                    $registro->id_evento = $idEvento;
                    $registro->asistio = 1;
                    $notificacion = $registro;
                }

                $notificacion->asistio = 1;
                $notificacion->save();

                $puntaje = $usuario->puntaje;
                $sumaPuntajes = $puntaje + $evento->puntos_otorgados;
                $usuario->update(['puntaje' => $sumaPuntajes]);

                return response()->json(array(
                    'status' => 200,
                    'success' => true,
                    'errors' => [],
                    'data' => [
                        'puntos_otorgados' => $evento->puntos_otorgados,
                        'asistio' => 1
                    ]
                ));
            } else {
                return response()->json(array(
                    'status' => 500,
                    'success' => false,
                    'errors' => ['Ya has sido registrado'],
                    'data' => [
                        'puntos_otorgados' => 0,
                        'asistio' => 0
                    ]
                ));
            }
        } else {
            return response()->json(array(
                'status' => 500,
                'success' => false,
                'errors' => ['No te encuentras en el rango del evento'],
                'data' => [
                    'puntos_otorgados' => 0,
                    'asistio' => 0
                ]
            ));
        }
    }

    public function registrar(Request $request) {
        $token = $request->input('token');
        $id_evento = $request->input('id_evento');
        $fecha_actual = Carbon::now('America/Mexico_City')->toDateTimeString();

        $evento = Evento::find($id_evento);

        $codigo_guanajoven = CodigoGuanajoven::where(
            'token', $token
        )->first();

        if(!is_null($evento)) {
            if(!is_null($codigo_guanajoven)) {
                $usuario = User::find($codigo_guanajoven->id_usuario);
                if(!is_null($usuario)) {
                    $registro = $evento->usuarios()->find($usuario->id);
                    if(is_null($registro)) {
                        $evento->usuarios()->attach($usuario);
                        $nuevo_registro = $evento->usuarios()->find($usuario->id);
                        $this->updateUserData($usuario, $evento, $nuevo_registro);

                        return $this->sendResponse(200, true, [], $usuario->email);
                    } else {
                        if($registro->pivot->asistio == 0) {
                            $this->updateUserData($usuario, $evento, $registro);

                            return $this->sendResponse(200, true, [], $usuario->email);
                        } else {
                            return $this->sendResponse(200, false, ['Usuario ya habia sido registrado'], null);
                        }
                    }
                } else {
                    return $this->sendResponse(200, false, ['No existe usuario'], null);
                }
            } else {
                return $this->sendResponse(200, false, ['No existe codigo'], null);
            }
        } else {
            return $this->sendResponse(200, false, ['No existe evento'], null);
        }

    }

    public function usuariosRegistrados(Request $request) {
        $id_evento = $request->input("id_evento");

        $eventos = UsuarioEvento::where('id_evento', '=', $id_evento)
            ->where('asistio', '=', 1)
            ->get();

        if ($eventos != null) {

            $usuarios = array();

            foreach ($eventos as $evento) {
                $usuario = User::where('id', '=', $evento->id_usuario)->first();
                $datos_usuario = DatosUsuario::where('id_usuario', '=', $usuario->id)->get();
                $id_guanajoven = CodigoGuanajoven::where('id_usuario', '=', $usuario->id)->first();

                $usuario->nombre = $datos_usuario[0]->nombre;
                $usuario->apellido_paterno = $datos_usuario[0]->apellido_paterno;
                $usuario->apellido_materno = $datos_usuario[0]->apellido_materno;
                $usuario->ruta_imagen = $datos_usuario[0]->ruta_imagen;
                $usuario->id_guanajoven = $id_guanajoven->id_codigo_guanajoven;


                unset($usuario->id);
                unset($usuario->admin);
                unset($usuario->api_token);
                unset($usuario->created_at);
                unset($usuario->updated_at);
                unset($usuario->deleted_at);
                unset($usuario->puntaje);

                array_push($usuarios, $usuario);
            }

            return response()->json(array(
                'status' => 200,
                'success' => true,
                'errors' => [],
                'data' => $usuarios
            ));
        } else {
            return response()->json(array(
                'status' => 200,
                'success' => true,
                'errors' => [],
                'data' => null
            ));
        }

    }

    public function usuariosInteresados(Request $request) {
        $id_evento = $request->input("id_evento");

        $eventos = UsuarioEvento::where('id_evento', '=', $id_evento)
            ->where('asistio', '=', 0)
            ->where('le_interesa', '=', 1)
            ->get();

        if ($eventos != null) {

            $usuarios = array();

            foreach ($eventos as $evento) {
                $usuario = User::where('id', '=', $evento->id_usuario)->first();

                $datos_usuario = DatosUsuario::where('id_usuario', '=', $usuario->id)->get();
                $id_guanajoven = CodigoGuanajoven::where('id_usuario', '=', $usuario->id)->first();


                $usuario->nombre = $datos_usuario[0]->nombre;
                $usuario->apellido_paterno = $datos_usuario[0]->apellido_paterno;
                $usuario->apellido_materno = $datos_usuario[0]->apellido_materno;
                $usuario->ruta_imagen = $datos_usuario[0]->ruta_imagen;
                $usuario->id_guanajoven = $id_guanajoven->id_codigo_guanajoven;

                unset($usuario->id);
                unset($usuario->admin);
                unset($usuario->api_token);
                unset($usuario->created_at);
                unset($usuario->updated_at);
                unset($usuario->deleted_at);
                unset($usuario->puntaje);

                array_push($usuarios, $usuario);
            }

            return response()->json(array(
                'status' => 200,
                'success' => true,
                'errors' => [],
                'data' => $usuarios
            ));
        } else {
            return response()->json(array(
                'status' => 200,
                'success' => true,
                'errors' => [],
                'data' => null
            ));
        }
    }

    /**
     * Evento: Enviar notificacion
     * params: [api_token, id_evento]
     * Se llama cuando un usuario se interesa en un evento nuevo
     * @param Request $request
     * @return Response
     */
    public function enviarNotificacion(Request $request) {
        $apiToken = $request->api_token;
        $idEvento = $request->id_evento;
        $evento = Evento::find($idEvento);
        $usuario = Auth::guard('api')->user();
        
        if ($evento->usuarios()->find($usuario->id)) {
            return response()->json(array(
                "success" => false,
                "status" => 500,
                "errors" => ["El usuario ya se registró en este evento."]
            ));
        } else {
            $datosUsuario = DatosUsuario::where('id_usuario', $usuario->id)->first();
            $usuario->notify(new EventoNotificacion($evento, $datosUsuario));
            return response()->json(array(
                "success" => true,
                "status" => 200,
                "errors" => [],
                "data" => $evento
            ));
        }
        
    }

    private function updateUserData($usuario, $evento, $registro) {
        $puntaje = $evento->puntos_otorgados + $usuario->puntaje;
        $usuario->puntaje = $puntaje;
        $usuario->save();

        $registro->pivot->dispositivo = 2;
        $registro->pivot->asistio = 1;
        $registro->pivot->save();
    }

    private function sendResponse($status, $success, $errors, $data) {
        return response()->json(array(
            'status' => $status,
            'success' => $success,
            'errors' => $errors,
            'data' => $data
        ));
    }



}
