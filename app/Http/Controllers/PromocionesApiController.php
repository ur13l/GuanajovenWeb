<?php

namespace App\Http\Controllers;

use App\Promocion;
use App\Empresa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PromocionesApiController extends Controller
{
    /**
     * Metodo para la obtención de convocatorias para la app.
     * @route /api/convocatorias/
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerEmpresasPromociones(Request $request) {
        $timestamp = $request->input('timestamp');
      $empresas = Empresa::where('deleted_at','=' ,null)
    //  ->where('updated_at', '>=', Carbon::now('America/Mexico_City'))
      ->where('updated_at', '>=', $timestamp)
      ->where('estatus', '=', 'Activo')
      ->orderBy('prioridad', 'asc')
      ->get();
      $promociones = Promocion::where('deleted_at','=' ,null)->get();
    foreach ($empresas as $empresa){
        $pivot = array();
        foreach($promociones as $promocion){
          if($empresa->id_empresa == $promocion->id_empresa ){
            array_push($pivot,$promocion);
          }
        }
        $empresa->promociones  = $pivot;
      }
    /*  dd($empresas[0]->promociones[0]);
        $timestamp = $request->input('timestamp');

        $convocatorias = Convocatoria::where('fecha_cierre', '>=', Carbon::now('America/Mexico_City'))
            ->where('updated_at', '>', $timestamp)
            ->orderBy('fecha_cierre')
            ->with('documentos')
            ->withTrashed()
            ->get();*/
        return response()->json(array(
            "success" => true,
            "status" => 200,
            "errors" => [],
            "data" => $empresas
        ));
    }
}
