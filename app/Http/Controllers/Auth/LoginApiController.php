<?php
/**
 * Created by PhpStorm.
 * User: code
 * Date: 6/03/17
 * Time: 02:52 PM
 */

namespace App\Http\Controllers\Auth;


use App\DatosUsuario;
use App\Http\Controllers\Controller;
use App\Usuario;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginApiController extends Controller
{
    use AuthenticatesUsers;

    function login(Request $request){
        $correo = $request->input("email");
        $password = $request->input("password");
        $data = null;

        if (Auth::once(['email' => $correo, 'password' => $password])) {
            $usuario = Auth::user();
            $datosUsuario = DatosUsuario::where("id_usuario", $usuario->id)->first();

            $data = [
                "id" => $usuario->id,
                "correo" => $usuario->email,
                "api_token" => $usuario->api_token,
                "id_datos_usuario" => $datosUsuario->id_datos_usuario,
                "nombre" => $datosUsuario->nombre,
                "apellido_paterno" => $datosUsuario->apellido_paterno,
                "apellido_materno" => $datosUsuario->apellido_materno,
                "id_genero" => $datosUsuario->id_genero,
                "fecha_nacimiento" => $datosUsuario->fecha_nacimiento,
                "id_ocupacion" => $datosUsuario->id_ocupacion,
                "codigo_postal" => $datosUsuario->codigo_postal,
                "telefono" => $datosUsuario->telefono,
                "curp" => $datosUsuario->curp,
                "id_estado" => $datosUsuario->id_estado,
                "id_municipio" => $datosUsuario->id_municipio,
                "ruta_imagen" => $datosUsuario->ruta_imagen
            ];

            return response()->json([
                "success" => true,
                "errors" => [],
                "status" => 200,
                "data" => $data
            ]);
        } else {
            return response()->json([
                "success" => false,
                "errors" => ["Usuario o contraseña incorrectos"],
                "status" => 500,
                "data" => $data
            ]);
        }
    }
}
