<?php

namespace App\Http\Controllers;

use App\CodigoGuanajoven;
use App\Promocion;
use App\Empresa;
use App\UsuarioPromocion;
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
    public function obtenerEmpresasPromociones(Request $request)
    {
        $timestamp = $request->input('timestamp');
        $empresas = Empresa::where('deleted_at', '=', null)
            //  ->where('updated_at', '>=', Carbon::now('America/Mexico_City'))
            ->where('updated_at', '>=', $timestamp)
            ->where('estatus', '=', 'Activo')
            ->orderBy('prioridad', 'asc')
            ->get();
        $promociones = Promocion::where('deleted_at', '=', null)->get();
        foreach ($empresas as $empresa) {
            $pivot = array();
            foreach ($promociones as $promocion) {
                if ($empresa->id_empresa == $promocion->id_empresa) {
                    array_push($pivot, $promocion);
                }
            }
            $empresa->promociones = $pivot;
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

    public function registrar(Request $request)
    {
        $token = $request->get('token');
        $id_promocion = $request->get('id_promocion');

        $promocion = Promocion::where('id_promocion', '=', $id_promocion)->first();
        $codigo_guanajoven = CodigoGuanajoven::where('token', '=', $token)->first();


        if (isset($codigo_guanajoven)) {
            if (isset($promocion)) {
                $empresa = Empresa::where('id_empresa', '=', $promocion->id_empresa)->first();
                if (isset($empresa)) {
                    $usuario_promocion_save = new UsuarioPromocion();
                    $usuario_promocion_save->id_usuario = $codigo_guanajoven->id_usuario;
                    $usuario_promocion_save->id_empresa = $empresa->id_empresa;
                    $usuario_promocion_save->id_promocion = $promocion->id_promocion;
                    $usuario_promocion_save->codigo_promocion = $promocion->codigo_promocion;
                    $usuario_promocion_save->save();

                    return response()->json(array(
                        "success" => true,
                        "status" => 404,
                        "errors" => [],
                        "data" => true));
                } else {
                    return response()->json(array(
                        "success" => true,
                        "status" => 404,
                        "errors" => ['No existe la empresa'],
                        "data" => null));
                }

            } else {
                return response()->json(array(
                    "success" => true,
                    "status" => 404,
                    "errors" => ['No existe promocion'],
                    "data" => null));
            }

        } else {
            return response()->json(array(
                "success" => true,
                "status" => 404,
                "errors" => ['No existe id guanajoven'],
                "data" => null));
        }


    }

}
