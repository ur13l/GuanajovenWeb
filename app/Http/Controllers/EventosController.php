<?php

namespace App\Http\Controllers;


use App\Evento;
use App\TipoEvento;
use Illuminate\Http\Request;

class EventosController extends Controller {
    public function index(Request $request) {
        return view('eventos.index');
    }

    public function nuevoEvento(Request $request) {
        $tipos = TipoEvento::all();
        return view('eventos.nuevoEvento', array('tipos' => $tipos));
    }

    public function guardarEvento(Request $request) {
        $action = $request->input('action');

        switch ($action) {
            case 'create':
                $titulo = $request->input('titulo');
                $descripcion = $request->input('descripcion');
                $fechaInicio = $request->input('fecha_inicio');
                $fechaFin = $request->input('fecha_fin');
                $tipo = $request->input('tipo');

                $evento = Evento::create([
                    'titulo' => $titulo,
                    'descripcion' => $descripcion,
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin,
                    'id_tipo_evento' => $tipo,
                    'latitud'
                ]);

                $consulta = "INSERT INTO evento VALUES (0,'$titulo', '$descripcion', '$fechaInicio', '$fechaFin', '$tipo', now(), 1)";
                mysqli_query($conexion, $consulta);
                echo '{"success":"true"}';
                break;
            case 'update':
                $id = $_POST['id'];
                $titulo = $_POST['titulo'];
                $descripcion = $_POST['descripcion'];
                $fechaInicio = $_POST['fecha_inicio'];
                $fechaFin = $_POST['fecha_fin'];
                $tipo = $_POST['tipo'];
                $consulta = "UPDATE evento SET titulo='$titulo', descripcion='$descripcion', fecha_inicio='$fechaInicio', fecha_fin='$fechaFin', tipo='$tipo', fecha_actualizacion=now()
              WHERE id_evento = '$id'";
                mysqli_query($conexion, $consulta);
                echo '{"success":"true"}';
                break;
            case 'read':
                $page = $_POST['page'];
                $min = $page * 10;
                $consulta = "SELECT * FROM evento WHERE estado = 1 ORDER BY
      CASE WHEN fecha_inicio > NOW() THEN 1
           WHEN fecha_inicio < NOW() THEN 2
      END ASC, fecha_inicio LIMIT $min, 10";
                $result = mysqli_query($conexion, $consulta);
                $arr = array();
                while($row = mysqli_fetch_assoc($result)){
                    array_push($arr, $row);
                }
                echo json_encode($arr);
                break;
            case 'count':
                $consulta = "SELECT COUNT(id_evento) as pages FROM evento WHERE estado=1";
                $result = mysqli_query($conexion, $consulta);
                $row = mysqli_fetch_array($result);
                echo json_encode($row);
                break;
            case 'delete':
                $ids = json_decode($_POST['ids']);
                for($i = 0 ; $i < count($ids) ; $i++){
                    $consulta = "UPDATE evento SET estado=0, fecha_actualizacion=now() WHERE id_evento = '".$ids[$i]."'";
                    $result = mysqli_query($conexion, $consulta);
                }
                echo '{"success":"true"}';
                break;
        }
    }

    public function editarEvento(Request $request) {
        return view('eventos.editarEvento');
    }
}