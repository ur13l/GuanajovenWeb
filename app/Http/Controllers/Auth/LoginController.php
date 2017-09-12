<?php

namespace App\Http\Controllers\Auth;

use App\Funcionario;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\BitacoraUsuario;
use Carbon\Carbon;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $correo = $request->input("email");
        $password = $request->input("password");

        if (Auth::attempt(['email' => $correo, 'password' => $password])) {
            $usuario = User::where('email', $correo )->get()->first();
            if($usuario->admin == "1"){
                     $funcionario = Funcionario::where('id_usuario', '=', $usuario->id);
                return redirect()->intended('/eventos/inicio')->with('rol_funcionario', $funcionario->rol);
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

}
