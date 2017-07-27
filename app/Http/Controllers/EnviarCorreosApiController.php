<?php

namespace App\Http\Controllers;

use App\NotificacionConvocatoria;
use App\Http\Requests;
use App\NotificacionEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Mail;


class EnviarCorreosApiController extends Controller
{
    protected $id_usuario;
    protected $id_convocatoria;
    protected $curp_usuario;
    protected $nombre_convocatoria;

    protected $idEvento;
    protected $nombreEvento;

    //En caso de ser un email de Convocatoria
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
            ['curp_usuario' => $curp_usuario, 'titulo' => $nombre_convocatoria, 'tipo' => 'la convocatoria'],

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
            return view('correos.CorreoUsuarioListo', ['titulo', $this->nombre_convocatoria]);
        } else {
            return $this->enviarCorreoGuanajoven($this->id_usuario, $this->id_convocatoria, $this->curp_usuario, $this->nombre_convocatoria);
        }
    }

    //En caso de ser un email de Eventos
    public function guardarVariablesEvento(Request $request) {
        $this->id_usuario = $request->get('id_usuario');
        $this->idEvento = $request->get('id_evento');
        $this->curp_usuario = $request->get('curp_usuario');
        $this->nombreEvento = $request->get('nombre_evento');
        $this->validacionEvento();
    }

    public function validacionEvento() {
        $notificaciones = NotificacionEvento::where('id_usuario', $this->id_usuario)
                                            ->where('id_evento', $this->idEvento)
                                            ->count();

        if ($notificaciones > 0) {
            return view('correos.CorreoUsuarioListo', ['titulo' => $this->nombreEvento]);
        } else {
            $this->enviarCorreoEvento($this->id_usuario, $this->idEvento, $this->curp_usuario, $this->nombreEvento);
        }
    }

    public function enviarCorreoEvento($idUsuario, $idEvento, $curp, $nombreEvento) {
        $registro = new NotificacionEvento();
        $registro->id_usuario = $idUsuario;
        $registro->id_evento = $idEvento;
        $registro->le_interesa = 1;
        $registro->save();

        Mail::send('correos.CorreoGuanajovenEnviado', [
            'curp_usuario' => $curp,
            'tipo' => 'el evento',
            'titulo' => $nombreEvento
        ], function ($message) use ($curp, $nombreEvento) {
            //Desde donde llega el mensaje
            $message->from('guanajoven@gmail.com', 'Guanajoven');
            //Mensaje para el usuario
            $message->to( '15240643@itleon.edu.mx', 'Administrador')
                    ->subject('Nuevo registro al evento: '.$nombreEvento);
        });

        return view('correos.CorreoUsuarioRegistrado');
    }
}
