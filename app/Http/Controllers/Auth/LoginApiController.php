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
use Illuminate\Support\MessageBag;
use Validator;

class LoginApiController extends Controller
{
    use AuthenticatesUsers;

    function login(Request $request){
        $correo = $request->input("email");
        $password = $request->input("password");
        $data = [];

        if (Auth::once(['email' => $correo, 'password' => $password])) {
            $usuario = Auth::user();
            $data = [
                "id_usuario" => $usuario->id_usuario,
                "correo" => $usuario->email,
                "admin" => $usuario->admin,
                "api_token" => $usuario->api_token
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

    function registrar(Request $request) {
        $errors = [];
        $data = [];

        $reglas = [
            'email' => 'required|email|unique:usuario',
            'password' => 'required|confirmed',
            'nombre' => 'required|string',
            'id_genero' => 'required|integer',
            'codigo_postal' => 'required|integer|',
            'curp' => 'required|string'
        ];
        $input = [
            'email' => $request->input("email"),
            'password' => $request->input("password"),
            'password_confirmation' => $request->input("confirmar_password"),
            'nombre' => $request->input("nombre"),
            'id_genero' => $request->input("id_genero"),
            'codigo_postal' => $request->input("codigo_postal"),
            'curp' => $request->input("curp")
        ];
        $validacion = Validator::make($input, $reglas);

        if ($validacion->fails()) {
            foreach ($validacion->errors()->all() as $error) {
                array_push($errors, $error);
            }
        } else {
            //Usuario
            $correo = $request->input("email");
            $password = $request->input("password");

            $usuario = Usuario::create([
                'email' => $correo,
                'password' => $password,
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

            if (isset($usuario) && isset($datosUsuario)) {
                $data = [
                    "id_usuario" => $usuario->id_usuario,
                    "correo" => $usuario->email,
                    "api_token" => $usuario->api_token,
                    "id_datos_usuario" => $datosUsuario->id_datos_usuario,
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
                ];
            } else {
                array_push($errors, "¡Ops!, parece que algo salió mal. Verifíca que todos tus datos sean correctos.");
            }
        }

        if (count($errors) > 0) {
            return response()->json([
                "success" => false,
                "errors" => $errors,
                "status" => 500,
                "data" => $data
            ]);
        } else {
            return response()->json([
                "success" => true,
                "errors" => $errors,
                "status" => 200,
                "data" => $data
            ]);
        }
    }
}