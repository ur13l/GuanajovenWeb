<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;

class ImageController extends Controller {
    public static function guardarImagen($datos, $ruta, $nombre) {
        list($tipo, $datos) = explode(';', $datos);
        list(, $datos) = explode(',', $datos);
        list(, $ext) = explode('/', $tipo);

        $datos = base64_decode($datos);
        $rutaArchivo = $ruta . $nombre . "." . $ext;
        file_put_contents($rutaArchivo, $datos);
        return $rutaArchivo;
    }

    public static function eliminarImagen($url) {
        $datos = explode("/", $url);
        if (count($datos) > 3) {
            $ruta = $datos[count($datos) - 3] . "/" . $datos[count($datos) - 2] . "/" . $datos[count($datos) - 1];
            if (file_exists($ruta))
                unlink($ruta);
        }
    }
}