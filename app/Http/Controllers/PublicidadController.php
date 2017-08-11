<?php
/*
  Autor: Leonardo Lira Becerra.
  Descripción: Controlador para vista de Publicidad.
  Fecha: 27/01/2017.
*/

namespace App\Http\Controllers;

use App\Publicidad;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class PublicidadController {
    use ValidatesRequests;

    /**
     * Requerir logueo para las rutas que impliquen el módulo de usuarios
     * UsuariosController constructor.
     */
    public function __construct() {
        $this->middleware('auth.web');
    }

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

    /**
     * Función que permite eliminar un elemento de publicidad desde la parte web.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eliminar(Request $request) {
        $id = $request->input('id-eliminar');
        $publicidad = Publicidad::find($id);
        $publicidad->delete();
       return  redirect()->route('publicidad');
    }

    /**
     * Método para la creación de un elemento de publicidad desde la interfaz web.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function crear(Request $request) {

        $this->validate($request, [
            'titulo' => 'required',
            'fecha-inicio' => 'required',
            'fecha-fin' => 'required',
            'imagen' => 'required'
        ]);

        $titulo = $request->input('titulo');
        $descripcion = $request->input('descripcion');
        $fechaInicio = $request->input('fecha-inicio');
        $fechaFin = $request->input('fecha-fin');
        $url = $request->input('url');
        $rutaImagen = null;
        $imagen = $request->file('imagen');

        if ($request->file('imagen')->isValid()) {
            $destinationPath = 'storage/publicidad/'; // upload path
            $extension = $request->file('imagen')->getClientOriginalExtension(); // getting image extension
            $fileName = uniqid('pub_').'.'.$extension; // renameing image
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

        return redirect('/publicidad');
    }


}

?>
