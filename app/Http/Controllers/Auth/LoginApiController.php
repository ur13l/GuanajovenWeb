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
use Illuminate\Validation\Rule;
use Validator;

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

    function registrar(Request $request) {
        $errors = [];
        $regla = [ 'email' => 'email|unique:usuario' ];
        $input = [ 'email' => $request->input("email") ];
        $validacion = Validator::make($input, $regla);

        if ($validacion->fails()) {
            array_push($errors, "Este correo ya está registrado. Verifíca tu información");
        } else {
            //Usuario
            $correo = $request->input("email");
            $password = $request->input("password");
            $admin = $request->input("admin");

            $usuario = Usuario::create([
                'email' => $correo,
                'password' => $password,
                'admin' => $admin
            ]);

            //Datos Usuario
            $id_usuario = $usuario->id_usuario;
            $nombre = $request->input("nombre");
            $id_genero = $request->input("id_genero");
            $fecha_nacimiento = $request->input("fecha_nacimiento");
            $id_ocupacion = $request->input("id_ocupacion");
            $codigo_postal = $request->input("codigo_postal");
            $telefono = $request->input("telefono");
            $curp = $request->input("curp");
            $id_estado = $request->input("id_estado");
            $id_municipio = $request->input("id_municipio");
            $ruta_imagen = $request->input("ruta_imagen");

            $datosUsuario = DatosUsuario::create([
                'id_usuario' => $id_usuario,
                'nombre' => $nombre,
                'id_genero' => $id_genero,
                'fecha_nacimiento' => $fecha_nacimiento,
                'id_ocupacion' => $id_ocupacion,
                'codigo_postal' => $codigo_postal,
                'telefono' => $telefono,
                'curp' => $curp,
                'id_estado' => $id_estado,
                'id_municipio' => $id_municipio,
                'ruta_imagen' => $ruta_imagen
            ]);
        }

        if (isset($usuario) && isset($datosUsuario)) {
            $data = [
                "usuario" => [
                    "correo" => $usuario->email,
                    "api_token" => $usuario->api_token
                ],
                "datosUsuario" => [
                    "nombre" => $datosUsuario->nombre,
                    "id_genero" => $datosUsuario->id_genero,
                    "fecha_nacimiento" => $datosUsuario->fecha_nacimiento,
                    "id_ocupacion" => $datosUsuario->id_ocupacion,
                    "codigo_postal" => $datosUsuario->codigo_postal,
                    "telefono" => $datosUsuario->telefono,
                    "curp" => $datosUsuario->curp,
                    "id_estado" => $datosUsuario->id_estado,
                    "id_municipio" => $datosUsuario->id_municipio,
                    "ruta_imagen" => $datosUsuario->ruta_imagen
                ]
            ];

            return response()->json([
                "success" => true,
                "errors" => $errors,
                "status" => 200,
                "data" => $data
            ]);
        } else {
            array_push($errors, "¡Ops!, parece que algo salió mal. Verifíca que todos tus datos sean correctos.");

            return response()->json([
                "success" => false,
                "errors" => $errors,
                "status" => 200
            ]);
        }
    }
}