<?php
/**
 * Created by PhpStorm.
 * User: leonardolirabecerra
 * Date: 01/02/17
 * Time: 2:45 PM
 */

namespace App\Http\Controllers;


use App\Funcionario;
use Illuminate\Http\Request;

class UsuariosController extends Controller{

    /**
     * Requerir logueo para las rutas que impliquen el módulo de usuarios
     * UsuariosController constructor.
     */
    public function __construct() {
        $this->middleware('auth.web');
    }

    public function index(Request $request) {
        $usuarios = Funcionario::where('estatus', '=', 1)->paginate(20);

        return view('usuarios.index', ['usuarios' => $usuarios]);
    }
}
