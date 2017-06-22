<?php

namespace App\Http\Controllers;

use App\Convocatoria;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConvocatoriaApiController extends Controller
{
    /**
     * Metodo para la obtención de convocatorias para la app.
     * @route /api/convocatorias/
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerConvocatorias(Request $request) {
        $timestamp = $request->input('timestamp');

        $convocatorias = Convocatoria::where('fecha_cierre', '>=', Carbon::now('America/Mexico_City'))
            ->where('updated_at', '>', $timestamp)
            ->orderBy('fecha_cierre')
            ->with('documentos')
            ->withTrashed()
            ->get();
        return response()->json(array(
            "success" => true,
            "status" => 200,
            "errors" => [],
            "data" => $convocatorias
        ));
    }
}
