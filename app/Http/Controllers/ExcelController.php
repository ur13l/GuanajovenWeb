<?php

namespace App\Http\Controllers;

use App\CodigoGuanajoven;
use App\DatosUsuario;
use App\Evento;
use App\NotificacionEvento;
use App\User;
use FontLib\EOT\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use ZipArchive;


class ExcelController extends Controller {

    public function obtenerUsuarios(Request $request) {
        $id_evento = $request->input('id_evento');
        $correo = $request->input('correo');

        $eventos_usuarios_registrados = NotificacionEvento::where('id_evento', '=', $id_evento)
            ->where('asistio', '=', 1)
            ->get();

        $eventos_usuarios_interesados = NotificacionEvento::where('id_evento', '=', $id_evento)
            ->where('asistio', '=', 0)
            ->where('le_interesa', '=', 1)
            ->get();

        $usuarios_registrados = count($eventos_usuarios_registrados) > 0;
        $usuarios_interesados = count($eventos_usuarios_interesados) > 0;


        if ($usuarios_registrados || $usuarios_interesados) {
            if (true === $usuarios_registrados) {
                $evento = Evento::where('id_evento', '=', $eventos_usuarios_registrados[0]->id_evento)->first();
            } else {
                $evento = Evento::where('id_evento', '=', $eventos_usuarios_interesados[0]->id_evento)->first();
            }

            $this->generarExcel(collect($this->getUsuarios($eventos_usuarios_registrados)), collect($this->getUsuarios($eventos_usuarios_interesados)), $evento, $correo);
        } else {
            return response()->json(array(
                "success" => true,
                "status" => 200,
                "errors" => ["Evento sin registros"],
                "data" => false
            ));
        }


    }


    public function generarExcel($usuarios_registrados, $usuarios_interesados, $evento, $correo) {
        date_default_timezone_set('UTC');

        $date = date('Y-m-d h_i_s');

        Excel::create($evento->titulo.'_Registro_'.$date, function ($excel) use ($usuarios_registrados, $usuarios_interesados, $date, $evento) {
            $excel->setTitle($evento->titulo.'_Registro_'.$date);
            $excel->setCreator('Guanajoven')->setCompany('Guanajoven');

            $mysql_fecha_inicio = date_parse($evento->fecha_inicio);
            $mysql_fecha_fin = date_parse($evento->fecha_fin);

            $nombre_evento = ["Nombre_evento: ", $evento->titulo];
            $fecha_inicio = ["Fecha inicio: ", $mysql_fecha_inicio['day'].'/'.$mysql_fecha_inicio['month'].'/'.$mysql_fecha_inicio['year']];
            $fecha_fin = ["Fecha fin: ", $mysql_fecha_fin['day'].'/'.$mysql_fecha_fin['month'].'/'.$mysql_fecha_fin['year']];
            $descripcion = ["Descripción: ", $evento->descripcion];
            $area_responsable = ["Área responsable: ", $evento->area_responsable];
            $direccion = ["Dirección: ", $evento->direccion];

            $datos = array($nombre_evento, $fecha_inicio, $fecha_fin, $descripcion, $area_responsable, $direccion);

            $excel->sheet('Datos_Evento', function ($sheet) use ($datos) {
                $sheet->setOrientation('landscape');
                foreach ($datos as $dato) {
                    $sheet->appendRow($dato);
                }
            });


            $excel->sheet('Usuarios_Registrados', function($sheet) use($usuarios_registrados) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($usuarios_registrados, NULL, 'A1');
            });

            $excel->sheet('Usuarios_Interesados', function ($sheet) use($usuarios_interesados) {
               $sheet->setOrientation('landscape');
               $sheet->fromArray($usuarios_interesados, null, 'A1');
            });


        })->store('xlsx', 'excel');

        $this->enviarCorreo($evento->titulo.'_Registro_'.$date, $correo);

        return response()->json(array(
            "success" => true,
            "status" => 200,
            "errors" => [],
            "data" => true
        ))->send();

    }

    public function enviarCorreo($titulo, $correo) {

        Mail::send([], ['curp_usuario' => 'Esdfdgsdfg', 'titulo' => 'sdfgdsfgdfg', 'tipo' => 'la convocatoria'],

                function ($message) use ($titulo, $correo) {
                    //Desde donde llega el mensaje
                    $message->from('guanajoven@gmail.com', 'Guanajoven');
                    //Mensaje para el usuario
                    $message->to('jose.camacho@inquality.com.mx', 'Administrador')->subject($titulo);
                    $message->attach('excel/'.$titulo.'.xlsx');
                });


        unlink('excel/'.$titulo.'.xlsx');

    }

    public function getUsuarios($eventos) {
            $usuarios = array();

            foreach ($eventos as $evento) {
                $usuario = User::where('id', '=', $evento->id_usuario)->first();
                $codigo_guanajoven = CodigoGuanajoven::where('id_usuario', '=', $evento->id_usuario)->first();

                //dd($codigo_guanajoven);

                $datos_usuario = DatosUsuario::where('id_usuario', '=', $usuario->id)->first();

                $usuario->ID_Guanajoven = $codigo_guanajoven->id_codigo_guanajoven;
                $usuario->Nombre = $datos_usuario->nombre;
                $usuario->Apellido_Paterno = $datos_usuario->apellido_paterno;
                $usuario->Apellido_Materno = $datos_usuario->apellido_materno;
                $usuario->Curp = $datos_usuario->curp;

                $usuario->Correo = $usuario->email;


                if ($datos_usuario->id_genero == 1) {
                    $usuario->Genero = 'Masculino';
                } else {
                    $usuario->Genero = 'Femenino';
                }

                $fecha_hoy = date('Y-m-d', time());
                $array_fecha_nacimiento = date_parse($datos_usuario->fecha_nacimiento);
                $fecha_nacimiento_usuario = $array_fecha_nacimiento['year'].'-'.$array_fecha_nacimiento['month'].'-'.$array_fecha_nacimiento['day'];
                $años_usuario = date_diff(new \DateTime($fecha_hoy), new \DateTime($fecha_nacimiento_usuario))->y;

                $usuario->Edad = $años_usuario;

                unset($usuario->email);
                unset($usuario->id);
                unset($usuario->admin);
                unset($usuario->api_token);
                unset($usuario->created_at);
                unset($usuario->updated_at);
                unset($usuario->deleted_at);
                unset($usuario->puntaje);
                unset($usuario->id_google);
                unset($usuario->id_facebook);
                unset($usuario->password);
                unset($usuario->remember_token);

                array_push($usuarios, $usuario);
            }

            return $usuarios;
    }


}
