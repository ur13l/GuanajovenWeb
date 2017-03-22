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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class LoginApiController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Función para verificar el acceso de un usuario API
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        $correo = $request->input("email");
        $password = $request->input("password");
        $data = null;
        $user = Usuario::where("email", $correo)->first();

        if (isset($user) && $user->id_facebook == null && $user->id_google == null) {
            if (Auth::once(['email' => $correo, 'password' => $password])) {
                $usuario = Auth::user();
                $datosUsuario = DatosUsuario::where("id_usuario", $usuario->id)->first();

                $data = [
                    "id_usuario" => $usuario->id,
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
        } else {
            return response()->json([
                "success" => false,
                "errors" => ["Ya se ha iniciado sesión de otra manera"],
                "status" => 200,
                "data" => []
            ]);
        }
    }


    /**
     * Función para verificar el acceso de usuario mediante Googl
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginGoogle(Request $request) {
        $correo = $request->input("email");
        $id_google = $request->input("id_google");
        $data = null;
        $user = Usuario::where("email", $correo)->first();

        if (isset($user) && $user->id_google != null) {
            if (Auth::once(['email' => $correo, 'password' => '_']) && Hash::check($id_google, $user->id_google)) {
                $usuario = Auth::user();
                $datosUsuario = DatosUsuario::where("id_usuario", $usuario->id)->first();

                $data = [
                    "id_usuario" => $usuario->id,
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
                    "errors" => ["Usuario o Google incorrectos"],
                    "status" => 500,
                    "data" => $data
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "errors" => ["No existe este usuario"],
                "status" => 200,
                "data" => []
            ]);
        }
    }

    /**
     * Función para verificar el acceso de usuario mediante Facebook
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginFacebook(Request $request) {
        $correo = $request->input("email");
        $id_facebook = $request->input("id_facebook");
        $data = null;
        $user = Usuario::where("email", $correo)->first();

        if (isset($user) && $user->id_facebook != null) {
            if (Auth::once(['email' => $correo, 'password' => '_']) && Hash::check($id_facebook, $user->id_facebook)) {
                $usuario = Auth::user();
                $datosUsuario = DatosUsuario::where("id_usuario", $usuario->id)->first();

                $data = [
                    "id_usuario" => $usuario->id,
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
                    "errors" => ["Usuario o Facebook incorrectos"],
                    "status" => 500,
                    "data" => $data
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "errors" => ["No existe este usuario"],
                "status" => 200,
                "data" => []
            ]);
        }
    }
}
