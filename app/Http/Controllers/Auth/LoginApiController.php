<?php
/**
 * Created by PhpStorm.
 * User: code
 * Date: 6/03/17
 * Time: 02:52 PM
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginApiController extends Controller
{
    use AuthenticatesUsers;

    function login(Request $request){
        $correo = $request->input("email");
        $password = $request->input("password");

        if (Auth::once(['email' => $correo, 'password' => $password])) {
            return response()->json([
                "success" => true,
                "errors" => [],
                "status" => 200
            ]);
        } else {
            return response()->json([
                "success" => false,
                "errors" => ["Usuario o contraseña incorrectos"],
                "status" => 200
            ]);
        }
    }
}