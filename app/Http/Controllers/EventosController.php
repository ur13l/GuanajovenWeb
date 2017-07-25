<?php

namespace App\Http\Controllers;


use App\Evento;
use App\TipoEvento;
use Illuminate\Http\Request;

class EventosController extends Controller {

    /**
     * Función que retorna la vista de inicio con los eventos próximos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $eventos = Evento::proximos()->paginate(10);

        return view('eventos.index', ['eventos' => $eventos]);
    }

    /**
     * Función que muestra la vista para un nuevo evento
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function nuevo() {
        $tipos = TipoEvento::all();

        return view('eventos.nuevo', ['tipos' => $tipos]);
    }

    public function guardar(Request $request) {
        $titulo = $request->input('titulo');
        $descripcion = $request->input('descripcion');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $horaInicio = $request->input('hora_inicio');
        $horaFin = $request->input('hora_fin');
        $tipoEvento = $request->input('tipo-seleccionado');
        $posicion = explode(', ', $request->input('posicion'));
        $puntos = $request->input('puntos-otorgados');
        $area = $request->input('area-responsable');
        $direccion = null;

        $latitud = explode('(', $posicion[0])[1];
        $longitud = explode(')', $posicion[1])[0];

        $client = new \GuzzleHttp\Client();
        $resource = $client->get('https://maps.googleapis.com/maps/api/geocode/json?latlng='. $latitud .','. $longitud .'&sensor=false');
        dd($resource);
    }

}
