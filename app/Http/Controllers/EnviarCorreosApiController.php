<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Mail;




class EnviarCorreosApiController extends Controller
{

    public function enviarCorreoGuanajoven($curp_usuario, $nombre_convocatoria) {

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

}
