<?php

namespace App\Http\Controllers;

use App\Evento;
use Illuminate\Http\Request;

class EventoApiController extends Controller {

	public function obtenerEventos(Request $request) {
		$timestamp  = $request->input('timestamp');

		$eventos = Evento::where('updated_at','>', $timestamp);
		->orderBy('created_at');
		->withTrashed();
		->get();

		return response()->json(array(
			'status' => 200,
			'success' => true,
			'errors' => [],
			'data' => $eventos
		));
	}

}