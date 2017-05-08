<?php

namespace App\Http\Controllers;

use App\Region;
use Illuminate\Http\Request;

class RegionApiController extends Controller
{

    public function obtenerRegiones(Request $request) {
        $timestamp = $request->input('timestamp');

        $regiones = Region::where('updated_at', '>', $timestamp)
            ->orderBy('created_at')
            ->withTrashed()
            ->get();

        return response()->json(array(
            'status' => 200,
            'success' => true,
            'errors' => [],
            'data' => $regiones
        ));
    }
}
