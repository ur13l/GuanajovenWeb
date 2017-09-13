<?php

namespace App\Http\Controllers\Auth;

use App\Funcionario;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{

    use AuthenticatesUsers;
/*
    public function __construct() {
        $this->middleware('auth.web');
    }*/

    public function login(Request $request)
    {
        $correo = $request->input("email");
        $password = $request->input("password");

        if (Auth::attempt(['email' => $correo, 'password' => $password])) {
            $usuario = User::where('email', $correo )->get()->first();
            if($usuario->admin == "1"){
                     $funcionario = Funcionario::where('id_usuario', '=', $usuario->id)->first();
                     //$this->iniciar($funcionario->id_rol);
                return redirect()->intended('/eventos/inicio');
                //return redirect()->intended('/home')->with('id_rol', $funcionario->id_rol);
            } else {
                return view('index', ["errors" => ["Usuario sin permisos de administrador"]]);
            }
        } else {
            return view('index', ["errors" => ["Usuario o contraseña incorrecto"]]);
        }
    }

    public function getlogout(){
        Auth::logout();
        return redirect('/');
    }

    /*
    public function mostrarVista() {
        $id_rol = "id_rol";
        return view('layout.app')->with('id_rol', $id_rol);
    }*/



}
