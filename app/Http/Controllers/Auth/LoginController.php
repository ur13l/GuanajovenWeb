<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    public function login(Request $request) {
        $correo = $request->input("email");
        $password = $request->input("password");

        if (Auth::attempt(['email' => $correo, 'password' => $password])) {
            return redirect()->intended('/eventos');
        } else {
            return view('index', ["errors" => ["Usuario o contraseña incorrecto"]]);
        }
    }
}
