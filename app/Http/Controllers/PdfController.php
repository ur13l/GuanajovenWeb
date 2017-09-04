<?php

namespace App\Http\Controllers;

use App\DatosUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;



class PdfController extends Controller
{
    public function generarPDF(Request $request) {
        $api_token = $request->input('api_token');
        $usuario =  Auth::guard('api')->user();
        $datos_usuario = DatosUsuario::where("id_usuario", $usuario->id)->first();

        //Variables to use in view
        $nombre = $datos_usuario->nombre." ".$datos_usuario->apellido_paterno." ".$datos_usuario->apellido_materno;
        $curp = $datos_usuario->curp;

        $view = view('pdf.CredencialGuanajoven', compact('api_token','nombre', 'curp'))->render();
        $pdf = \App::make('dompdf.wrapper');

        if (!is_dir('pdf')) {
            mkdir('pdf', 0777, true);
        }

        $pdf->loadHTML($view)->save('pdf/'.$curp.'.pdf');


        $this->enviarCorreo($curp, $usuario->email);

        return response()->json(array(
            "success" => true,
            "status" => 200,
            "errors" => [],
            "data" => true
        ));
    }

    public function enviarCorreo($curp, $correo) {
        Mail::send([],['curp_usuario' => 'Esdfdgsdfg', 'titulo' => 'sdfgdsfgdfg', 'tipo' => 'la convocatoria'],

            function ($message) use ($curp, $correo) {
            //Desde donde llega el mensaje
                $message->from('guanajoven@gmail.com', 'Guanajoven');
                //Mensaje para el usuario
                $message->to( $correo, 'Administrador')->subject('Credencial ID Guanajoven');
                $message->attach('pdf/'.$curp.'.pdf');
            });

        //unlink('pdf/'.$curp.'.pdf');
    }

}
