<?php

namespace App\Http\Controllers;


use App\Evento;
use App\NotificacionEvento;
use App\TipoEvento;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class EventosController extends Controller {

    /**
     * Requerir logueo para las rutas que impliquen el módulo de usuarios
     * UsuariosController constructor.
     */
    public function __construct() {
        $this->middleware('auth.web');
    }

    public $meses = [
        'Enero' => '01',
        'Febrero' => '02',
        'Marzo' => '03',
        'Abril' => '04',
        'Mayo' => '05',
        'Junio' => '06',
        'Julio' => '07',
        'Agosto' => '08',
        'Septiembre' => '09',
        'Octubre' => '10',
        'Noviembre' => '11',
        'Diciembre' => '12',
    ];

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
        $evento = new Evento();

        $evento->titulo = '';
        $evento->descripcion = '';
        $evento->fecha_inicio = Carbon::now();
        $evento->fecha_fin = Carbon::tomorrow();
        $evento->id_tipo_evento = 1;
        $evento->latitud = 0;
        $evento->longitud = 0;
        $evento->direccion = '';
        $evento->puntos_otorgados = 0;
        $evento->area_responsable = '';
        $evento->save();

        return view('eventos.nuevo', [
            'tipos' => $tipos,
            'evento' => $evento,
            'fecha_inicio' => '',
            'fecha_fin' => '',
            'hora_inicio' => '',
            'hora_fin' => '',
            'latitud' => 21.095570,
            'longitud' => -101.616843
        ]);
    }

    /**
     * Función para guardar un nuevo evento
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function guardar(Request $request, $idEvento) {
        $titulo = $request->input('titulo');
        $descripcion = $request->input('descripcion');
        $fechaI = $request->input('fecha_inicio');
        $fechaF = $request->input('fecha_fin');
        $horaI = $request->input('hora_inicio');
        $horaF = $request->input('hora_fin');
        $tipoEvento = $request->input('tipo-seleccionado');
        $posicion = explode(', ', $request->input('posicion'));
        $puntos = $request->input('puntos-otorgados');
        $area = $request->input('area-responsable');

        //Obtener latitud y longitud
        $latitud = explode('(', $posicion[0])[1];
        $longitud = explode(')', $posicion[1])[0];

        //Petición a Google para obtener la dirección a partir de latitud y longitud
        $client = new Client();
        $resource = $client->get('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $latitud . ',' . $longitud . '&sensor=true');
        $resultado = json_decode($resource->getBody());
        $direccion = $resultado->results[0]->formatted_address;

        //Formatear fechas con horas
        $fechaI = explode(' ', $fechaI);
        $horaI = explode(':', $horaI);
        $anioI = $fechaI[2];
        $mesI = rtrim($fechaI[1], ',');
        $mesI = $this->meses[$mesI];
        $diaI = $fechaI[0];
        $horaIn = $horaI[0];
        $MinIn = $horaI[1];


        $fechaF = explode(' ', $fechaF);
        $horaF = explode(':', $horaF);
        $anioF = $fechaF[2];
        $mesF = rtrim($fechaF[1], ',');
        $mesF = $this->meses[$mesF];
        $diaF = $fechaF[0];
        $horaFn = $horaF[0];
        $MinFn = $horaF[1];

        $fechaInicio = Carbon::create($anioI, $mesI, $diaI, $horaIn, $MinIn, 0);
        $fechaFin = Carbon::create($anioF, $mesF, $diaF, $horaFn, $MinFn, 0);

        //Guardar evento
        $evento = Evento::find($idEvento);

        $evento->titulo = $titulo;
        $evento->descripcion = $descripcion;
        $evento->fecha_inicio = $fechaInicio->toDateTimeString();
        $evento->fecha_fin = $fechaFin->toDateTimeString();
        $evento->id_tipo_evento = $tipoEvento;
        $evento->latitud = $latitud;
        $evento->longitud = $longitud;
        $evento->direccion = $direccion;
        $evento->puntos_otorgados = $puntos;
        $evento->area_responsable = $area;

        try {
            $evento->save();
            return redirect()->to('/eventos/inicio');
        } catch(\Exception $ex) {
            $tipos = TipoEvento::all();

            return view('eventos.nuevo', ['tipos' => $tipos, 'mensaje' => 'Ocurrió un error al guardar el evento']);
        }
    }

    /**
     * Función para la edición de los detalles de un evento
     * @param $idEvento
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editar($idEvento) {
        $evento = Evento::find($idEvento);
        $tipos = TipoEvento::all();
        list($fechaInicio, $horaInicio) = explode(' ', $evento->fecha_inicio);
        list($fechaFin, $horaFin) = explode(' ', $evento->fecha_fin);

        return view('eventos.editar', [
            'tipos' => $tipos,
            'evento' => $evento,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'hora_inicio' => $horaInicio,
            'hora_fin' => $horaFin,
            'latitud' => $evento->latitud,
            'longitud' => $evento->longitud
        ]);
    }

    public function eliminar(Request $request) {
        $idEvento = $request->input('idEvento');
        $evento = Evento::find($idEvento);

        try {
            $evento->delete();
            return response()->json([
                'status' => 200
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 500
            ]);
        }
    }

    public function estadistica($idEvento) {
        $evento = Evento::find($idEvento);
        $asistentes = NotificacionEvento::where('id_evento', $evento->id_evento)->get();

        if (isset($asistentes)) {
            $usuariosAsistentes = [];
            $usuariosInteresados = [];

            foreach ($asistentes as $asistente) {
                $usuario = User::find($asistente->id_usuario);

                if (isset($usuario)) {
                    if ($asistente->asistio == 1) {
                        array_push($usuariosAsistentes, $usuario);
                    } else {
                        array_push($usuariosInteresados, $usuario);
                    }
                }
            }
        } else {
            $usuariosAsistentes = [];
        }

        return view('eventos.estadistica', [
            'titulo' => $evento->titulo,
            'usuariosAsistentes' => $usuariosAsistentes,
            'usuariosInteresados' => $usuariosInteresados
        ]);
    }
}
