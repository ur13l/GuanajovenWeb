<?php

namespace App\Http\Controllers;

use App\DatosUsuario;
use App\Evento;
use App\NotificacionEvento;
use App\Notifications\EventoNotificacion;
use App\User;
use Illuminate\Http\Request;

class EventoNotificacionController extends Controller {
    public function enviarNotificacion(Request $request) {
        $idUsuario = $request->input('id_usuario');
        $idEvento = $request->input('id_evento');
        $notificaciones = NotificacionEvento::where('id_usuario', $idUsuario)->where( 'id_evento', $idEvento)->count();

        if ($notificaciones > 0) {
            return response()->json(array(
                "success" => false,
                "status" => 500,
                "errors" => []
            ));
        } else {
            $usuario = User::find($idUsuario);
            $evento = Evento::where('id_evento', $idEvento)->first();
            $datosUsuario = DatosUsuario::where('id_usuario', $idUsuario)->first();
            $usuario->notify(new EventoNotificacion($evento, $datosUsuario));
        }
    }
}
