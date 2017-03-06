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

        return response($usuario);
    }
}