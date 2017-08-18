<?php

namespace App\Http\Controllers;

use App\DatosUsuario;
use App\Evento;
use App\NotificacionEvento;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mail;


class ExcelController extends Controller {

    public function obtenerUsuarios(Request $request) {
        $id_evento = $request->input('id_evento');
        $correo = $request->input('correo');

        $eventos = NotificacionEvento::where('id_evento', '=', $id_evento)
            ->where('asistio', '=', 1)
            ->get();

        if (count($eventos) > 0) {
            $usuarios = array();

            foreach ($eventos as $evento) {
                $usuario = User::where('id', '=', $evento->id_usuario)->first();

                $datos_usuario = DatosUsuario::where('id_usuario', '=', $usuario->id)->first();

                $usuario->Email = $usuario->email;
                $usuario->Nombre = $datos_usuario->nombre;
                $usuario->Apellido_Paterno = $datos_usuario->apellido_paterno;
                $usuario->Apellido_Materno = $datos_usuario->apellido_materno;
                $usuario->Curp = $datos_usuario->curp;

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

            $evento = Evento::where('id_evento', '=', $eventos[0]->id_evento)->first();

            $this->generarExcel(collect($usuarios), $evento, $correo);
        } else {
            return response()->json(array(
                "success" => true,
                "status" => 200,
                "errors" => ["Evento sin registros"],
                "data" => false
            ));
        }
    }


    public function generarExcel($usuarios, $evento, $correo) {
        date_default_timezone_set('UTC');

        $date = date('Y-m-d h_i_s');

        Excel::create($evento->titulo.'_Registro_'.$date, function ($excel) use ($usuarios, $date, $evento) {
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

            $excel->sheet('Usuarios_Registrados', function($sheet) use($usuarios) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($usuarios, NULL, 'A1');
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
                    $message->to($correo, 'Administrador')->subject($titulo);
                    $message->attach('excel/'.$titulo.'.xlsx');
                });


        unlink('excel/'.$titulo.'.xlsx');

    }

}
