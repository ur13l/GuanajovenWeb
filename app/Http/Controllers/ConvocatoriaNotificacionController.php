<?php

namespace App\Http\Controllers;

use App\DatosUsuario;
use Illuminate\Http\Request;
use App\User;
use App\Convocatoria;
use App\Notifications\ConvocatoriaNotification;

class ConvocatoriaNotificacionController extends Controller
{

    public function enviarNotificacion(Request $request) {

        $usuario = User::where('id', '=', $request->input('id_usuario'))->firstOrFail();
        $convocatoria = Convocatoria::where('id_convocatoria', '=', $request->input('id_convocatoria'))->firstOrFail();
        $datos_usuario = DatosUsuario::where('id_usuario', '=', $request->input('id_usuario'))->firstOrFail();

        $usuario->notify(new ConvocatoriaNotification($convocatoria, $datos_usuario));

    }

}
