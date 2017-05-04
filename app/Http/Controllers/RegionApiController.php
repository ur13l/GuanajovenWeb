<?php

namespace App\Http\Controllers;

use App\Region;
use Illuminate\Http\Request;

class RegionApiController extends Controller
{

    public function obtenerRegiones(Request $request) {
        $regiones = Region::all();
        return response()->json(array(
            'status' => 200,
            'success' => true,
            'errors' => [],
            'data' => $regiones
        ));
    }
}
