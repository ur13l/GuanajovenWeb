<?php
#Autor: Uriel Infante
#Controlador de los eventos, CRUD de eventos en la base de datos..
#Fecha: 15/05/2016
include("../../app_php/conexion/conexion.php");
$conexion = connect();
$action = $_POST['action'];

$consulta = "SET NAMES UTF8";
mysqli_query($conexion, $consulta);

switch($action){
  case 'create':
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fechaInicio = $_POST['fecha_inicio'];
    $fechaFin = $_POST['fecha_fin'];
    $tipo = $_POST['tipo'];
    $consulta = "INSERT INTO evento VALUES (0,'$titulo', '$descripcion', '$fechaInicio', '$fechaFin', '$tipo', now())";
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
    $consulta = "SELECT * FROM evento ORDER BY fecha_actualizacion DESC LIMIT $min, 10";
    $result = mysqli_query($conexion, $consulta);
    $arr = array();
    while($row = mysqli_fetch_array($result)){
      array_push($arr, $row);
    }
    echo json_encode($arr);
  break;
  case 'count':
    $consulta = "SELECT COUNT(id_evento) as pages FROM evento";
    $result = mysqli_query($conexion, $consulta);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
    break;
}
$conexion->close();

 ?>
