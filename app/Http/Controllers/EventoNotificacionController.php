<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventoNotificacionController extends Controller {
    //TODO: Modificar este archivo para la parte de Eventos
    public function enviarNotificacion(Request $request) {
        $id_usuario = $request->input('id_usuario');
        $id_convocatoria = $request->input('id_convocatoria');
        if (NotificacionConvocatoria::where('id_usuario', $id_usuario)->where( 'id_convocatoria', $id_convocatoria)->count() > 0) {
            return response()->json(array(
                "success" => false,
                "status" => 500,
                "errors" => []
            ));
        } else {
            $usuario = User::where('id', '=', $request->input('id_usuario'))->firstOrFail();
            $convocatoria = Convocatoria::where('id_convocatoria', '=', $request->input('id_convocatoria'))->firstOrFail();
            $datos_usuario = DatosUsuario::where('id_usuario', '=', $request->input('id_usuario'))->firstOrFail();
            $usuario->notify(new ConvocatoriaNotification($convocatoria, $datos_usuario));
        }
    }
}
