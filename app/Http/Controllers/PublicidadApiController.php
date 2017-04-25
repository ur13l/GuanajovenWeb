<?php

namespace App\Http\Controllers;

use App\Publicidad;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicidadApiController extends Controller
{


    /**
     * Metodo para la obtención de los items publicitarios que se estarán mostrando en la interfaz principal.
     * @route /api/publicidad
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerPublicidad(Request $request) {
        $anuncios = Publicidad::where('fecha_inicio', '<=', Carbon::now())
            ->where('fecha_fin', '>=', Carbon::now())
            ->orderBy('fecha_fin')
            ->get();
        return response()->json(array(
            "success" => true,
            "status" => 200,
            "errors" => [],
            "data" => $anuncios
        ));
    }
}
