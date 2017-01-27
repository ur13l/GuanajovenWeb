<?php
#Autor: Uriel Infante
#Script que revisa si existen las imágenes necesarias con su respectivo JSON
#Fecha: 22/08/2016
#

$array = [];
$route ='../../res/imagenes/';
if ($handle = opendir($route)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $ext = explode(".", $entry);
            if($ext[1] == "json"){
              $string = file_get_contents($route . $entry);
              $json_a = json_decode($string, true);
              $array[] = $json_a;
            }

        }
    }
    closedir($handle);
    echo json_encode($array);
}

 ?>
