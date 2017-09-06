<?php

namespace App\Http\Controllers\Auth;

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
                     $bitacora = BitacoraUsuario::create(array(
                          'id_usuario' => $usuario->id,
                          'fecha' => Carbon::now('America/Mexico_City')
                      ));
                return redirect()->intended('/eventos/inicio');
            }else{
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
