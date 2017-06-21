<?php

namespace App\Utils;

class FileUtils {


    public static function guardar($file, $destinationPath, $prefix){
        if ($file->isValid()) {
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $fileName =uniqid($prefix).'.'.$extension; // renameing image
            $file->move($destinationPath, $fileName); // uploading file to given path
            return url($destinationPath . $fileName);
        }
        return null;
    }

    /**
     * Eliminar imagen
     * Método estático que permite la eliminación de una imagen si esta existe dentro del servidor.
     * @param $url
     */
    public static function eliminar($url){
        $spl = explode("/", $url);
        if(count($spl) > 3) {
            $path = $spl[count($spl) - 3] . "/" . $spl[count($spl) - 2] . "/" . $spl[count($spl) - 1];
            if (file_exists($path))
                unlink($path);
        }
    }
}
