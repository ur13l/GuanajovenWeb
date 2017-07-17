<?php
/*
  Autor: Leonardo Lira Becerra.
  Descripción: Controlador para vista de Convocatorias.
  Fecha: 31/01/2017.
*/

namespace App\Http\Controllers;


use App\Empresa;
use App\Documento;
use App\Formato;
use App\Utils\FileUtils;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaController {
    use ValidatesRequests;

    /**
     * Index [GET]
     * Carga el index de empresa con el listado de estas para revisar detalles, crear y eliminar
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $empresas = Empresa::orderBy('empresa')->get();
        return view('empresas.index', array('empresas' => $empresas));
    }

    /**
     * Nueva Empresa [GET]
     * Método para mostrar la vista con el formulario para nueva empresa.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function nueva(Request $request) {
        return view('empresas.nueva');
    }

    /**
     * Editar empresa [GET]
     * Este método devuelve la vista para editar una empresa seleccionada de acuerdo a su id.
     * @param $id_empresa
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function vistaEditar($id_empresa) {
        $empresa = Empresa::find($id_empresa);
        $promociones = DB::table('promocion')->where('id_empresa','=',$empresa->id_empresa)->where('deleted_at','=',null)->get(); //'promociones' => $promociones
        foreach ($promociones as $promocion){
        $promocion->fecha_inicio = date('Y-m-d', strtotime($promocion->fecha_inicio));
        $promocion->fecha_fin = date('Y-m-d', strtotime($promocion->fecha_fin));
        //  ->format('d-m-Y');
        }
        $empresa->promociones = $promociones;


        return view('empresas.editar', array('empresa' => $empresa ));
    }


    /**
     * Eliminar Empresa [POST]
     * Función que permite eliminar una empresa del sistema.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eliminar(Request $request) {
        $id = $request->input('id-eliminar');
        $empresa = Empresa::find($id);
        $empresa->delete();
        return  redirect()->route('empresas');
    }


    /**
     * Crear empresa [POST]
     * Funcionalidad para crear una empresa en la interfaz web.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function crear(Request $request) {
        $this->validate($request, [
            'empresa' => 'required',
            'logo' => 'required',
            'nombre_comercial' => 'required',
            'razon_social' => 'required',
            'convenio' => 'required',
            'estatus' => 'required',
            'prioridad' => 'required',
            'url_empresa' => 'required'
        ]);


        $empresa = $request->input('empresa');
        $convenio = $request->input('convenio');
        $nombre_comercial = $request->input('nombre_comercial');
        $razon_social = $request->input('razon_social');
        $estatus = $request->input('estatus');
        $prioridad = $request->input('prioridad');
        $url_empresa = $request->input('url_empresa');
        $rutaImagen = null;

        $imagen = $request->file('logo');
        $documentos = $request->file('documentos');

        //Cargado de la imagen principal de la convocatoria.
        $rutaImagen = FileUtils::guardar($request->file('logo'), 'storage/promociones/', 'prom_');

        //Creación de la convocatoria.
        $promocion = Empresa::create(array(
            'empresa' => $empresa,
            'convenio' => $convenio,
            'nombre_comercial' => $nombre_comercial,
            'razon_social' => $razon_social,
            'estatus' => $estatus,
            'prioridad' => $prioridad,
            'url_empresa' => $url_empresa,
            'logo' => $rutaImagen
        ));


        return redirect('/empresas');
    }




    /**
     * Editar empresa [POST]
     * Funcionalidad para editar una empresa en la interfaz web.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function editar(Request $request) {
        //Se actualiza la empresa seleccionada
        $id = $request->input('id_empresa');
        $empresa = Empresa::find($id);
        $empresa->update($request->all());
        //Se elimina la imagen anterior (en caso de haberse cambiado)
        $file = $request->file('imagen');
        if(isset($file)) {
            FileUtils::eliminar($empresa->logo);
            $empresa->logo = FileUtils::guardar($file, 'storage/promociones/', 'prom_');
        }
        $empresa->save();
        return redirect('/empresas/editar/'.$empresa->id_empresa);
    }



}
