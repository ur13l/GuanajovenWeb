<?php

namespace App\Http\Controllers;

use App\NotificacionConvocatoria;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Mail;


class EnviarCorreosApiController extends Controller
{
    protected $id_usuario;
    protected $id_convocatoria;
    protected $curp_usuario;
    protected $nombre_convocatoria;

    public function index(Request $request) {
        $this->id_usuario = $request->get('id_usuario');
        $this->id_convocatoria = $request->get('id_convocatoria');
        $this->curp_usuario = $request->get('curp_usuario');
        $this->nombre_convocatoria = $request->get('nombre_convocatoria');
        $this->validacion();
    }

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

    public function validacion() {
        if (NotificacionConvocatoria::where('id_usuario', $this->id_usuario)->where('id_convocatoria', $this->id_convocatoria)->count() > 0) {
            return view('correos.CorreoUsuarioListo');
        } else {
            return $this->enviarCorreoGuanajoven($this->id_usuario, $this->id_convocatoria, $this->curp_usuario, $this->nombre_convocatoria);
        }
    }

}
