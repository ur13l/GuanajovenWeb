<?php

namespace App\Http\Controllers;

use App\NotificacionConvocatoria;
use App\Http\Requests;
use Mail;




class EnviarCorreosApiController extends Controller
{

    public function enviarCorreoGuanajoven($id_usuario, $id_convocatoria,$curp_usuario, $nombre_convocatoria) {
        $registro = new NotificacionConvocatoria();
        $registro->id_usuario = $id_usuario;
        $registro->id_convocatoria = $id_convocatoria;
        $registro->save();

        Mail::send('correos.CorreoGuanajovenEnviado',
            //variables para la vista
            ['curp_usuario' => $curp_usuario, 'nombre_convocatoria' => $nombre_convocatoria],

            function ($message) use ($curp_usuario, $nombre_convocatoria) {
            //Desde donde llega el mensaje
            $message->from('guanajoven@gmail.com', 'Guanajoven');
            //Mensaje para el usuario
            $message->to( '15240643@itleon.edu.mx', 'Administrador')->subject('Nuevo registro a convocatoria: '.$nombre_convocatoria);
        });

        return view('correos.CorreoUsuarioRegistrado');
    }

    public function validacion($id_usuario, $id_convocatoria,$curp_usuario, $nombre_convocatoria) {

        if (NotificacionConvocatoria::where('id_usuario', $id_usuario)->where( 'id_convocatoria', $id_convocatoria)->count() > 0) {
            return view('correos.CorreoUsuarioListo');
        } else {
            return $this->enviarCorreoGuanajoven($id_usuario, $id_convocatoria, $curp_usuario, $nombre_convocatoria);
        }

    }

}
