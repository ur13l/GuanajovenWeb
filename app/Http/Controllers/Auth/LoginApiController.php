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
use Validator;

class LoginApiController extends Controller
{
    use AuthenticatesUsers;

    function login(Request $request){
        $correo = $request->input("email");
        $password = $request->input("password");
        $data = null;

        if (Auth::once(['email' => $correo, 'password' => $password])) {
            $usuario = Auth::user();
            $datosUsuario = DatosUsuario::where("id", $usuario->id)->first();

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

    function registrar(Request $request) {
        $errors = [];
        $data = null;

        $reglas = [
            'email' => 'required|email|unique:usuario',
            'password' => 'required|confirmed',
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'id_genero' => 'required|integer',
            'codigo_postal' => 'required|integer|',
            'curp' => 'required|string'
        ];
        $input = [
            'email' => $request->input("email"),
            'password' => $request->input("password"),
            'password_confirmation' => $request->input("confirmar_password"),
            'nombre' => $request->input("nombre"),
            'apellido_paterno' => $request->input('apellido_paterno'),
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
            $ruta_imagen = "";
            $id = $usuario->id;
            $nombre = $request->input("nombre");
            $apellido_paterno = $request->input('apellido_paterno');
            $apellido_materno = $request->input('apellido_materno');
            $id_genero = $request->input("id_genero");
            $fecha_nacimiento = $request->input("fecha_nacimiento");
            $id_ocupacion = $request->input("id_ocupacion");
            $codigo_postal = $request->input("codigo_postal");
            $telefono = $request->input("telefono");
            $curp = $request->input("curp");
            $id_estado = $request->input("id_estado");
            $id_municipio = $request->input("id_municipio");

            $datos = $request->input('ruta_imagen');
            if (isset($datos)) {
                $ruta = "storage/usuarios/";
                $ruta_imagen = url(ImageController::guardarImagen($datos, $ruta, uniqid("usuario_")));
            }

            $datosUsuario = DatosUsuario::create([
                'id' => $id,
                'nombre' => $nombre,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno,
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

    function actualizar(Request $request) {
        $usuario =  Auth::guard('api')->user();
        $data = null;
        $errors = [];

        $reglas = [
            'nombre' => 'required|string',
            'id_genero' => 'required|integer',
            'codigo_postal' => 'required|integer|',
            'apellido_paterno' => 'required|string',
            'curp' => 'required|string'
        ];
        $input = [
            'nombre' => $request->input("nombre"),
            'id_genero' => $request->input("id_genero"),
            'codigo_postal' => $request->input("codigo_postal"),
            'apellido_paterno' => $request->input('apellido_paterno'),
            'curp' => $request->input("curp")
        ];
        $validacion = Validator::make($input, $reglas);

        if ($validacion->fails()) {
            foreach ($validacion->errors()->all() as $error) {
                array_push($errors, $error);
            }
        } else {
            //Datos Usuario
            $nombre = $request->input("nombre");
            $apellido_paterno = $request->input('apellido_paterno');
            $apellido_materno = $request->input('apellido_materno');
            $id_genero = $request->input("id_genero");
            $fecha_nacimiento = $request->input("fecha_nacimiento");
            $id_ocupacion = $request->input("id_ocupacion");
            $codigo_postal = $request->input("codigo_postal");
            $telefono = $request->input("telefono");
            $curp = $request->input("curp");
            $id_estado = $request->input("id_estado");
            $id_municipio = $request->input("id_municipio");

            $datosUsuario = DatosUsuario::where("id", $usuario->id)->first();

            //Imagen
            $ruta_imagen = '';
            ImageController::eliminarImagen($datosUsuario->ruta_imagen);
            $datos = $request->input('ruta_imagen');
            if (isset($datos)) {
                $ruta = "storage/usuarios/";
                $ruta_imagen = url(ImageController::guardarImagen($datos, $ruta, uniqid("usuario_")));
            }

            $actualiza = DatosUsuario::where("id", $usuario->id)
                ->update([
                    'nombre' => $nombre,
                    "apellido_paterno" => $apellido_paterno,
                    "apellido_materno" => $apellido_materno,
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

            if (isset($actualiza)) {
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
            } else {
                array_push($errors, "Hubo un error con los datos. Verifíca tu información");
            }
        }

        if (count($errors) == 0) {
            return response()->json([
                "success" => true,
                "errors" => [],
                "status" => 200,
                "data" => $data
            ]);
        } else {
            return response()->json([
                "success" => false,
                "errors" => ["¡Ops!, surgió un error en la actualización. Verifíca tus datos"],
                "status" => 500,
                "data" => $data
            ]);
        }
    }
}