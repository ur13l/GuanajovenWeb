<?php
/*
  Autor: Leonardo Lira Becerra.
  Descripción: Controlador para vista de Publicidad.
  Fecha: 27/01/2017.
*/

namespace App\Http\Controllers;

use App\Publicidad;
use Illuminate\Http\Request;

class PublicidadController {

    /**
     * Función que devuelve la vista del index de la sección de publicidad para el cargado de imágenes.
     * @route /publicidad/
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $anuncios = Publicidad::all();
        return view('publicidad.index',array("anuncios" => $anuncios));
    }

    public function eliminar(Request $request) {
        $id = $request->input('id-eliminar');
        $publicidad = Publicidad::find($id);
        $publicidad->delete();
        redirect()->route('publicidad');
    }

    public function crear(Request $request) {
        $titulo = $request->input('titulo');
        $descripcion = $request->input('descripcion');
        $fechaInicio = $request->input('fecha-inicio');
        $fechaFin = $request->input('fecha-fin');
        $url = $request->input('url');
        $rutaImagen = null;
        $imagen = $request->file('imagen');

        if ($request->file('imagen')->isValid()) {
            $destinationPath = 'storage/publicidad'; // upload path
            $extension = $request->file('imagen')->getClientOriginalExtension(); // getting image extension
            $fileName = rand(11111,99999).'.'.$extension; // renameing image
            $request->file('imagen')->move($destinationPath, $fileName); // uploading file to given path
            $rutaImagen = url($destinationPath . $fileName);
        }

        Publicidad::create(array(
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'url' => $url,
            'ruta_imagen' => $rutaImagen
        ));

        redirect()->route('publicidad');
    }


}

?>
