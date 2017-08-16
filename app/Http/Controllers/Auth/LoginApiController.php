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
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;


class LoginApiController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Función para verificar el acceso de un usuario API
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        $medio ="";
        $correo = $request->input("email");
        $password = $request->input("password");
        $data = null;
        $user = User::where("email", $correo)->first();
        if (isset($user) && $user->id_facebook == null && $user->id_google == null) {
            if (Auth::once(['email' => $correo, 'password' => $password])) {
                $usuario = User::with('datosUsuario')
                    ->with('codigoGuanajoven')
                    ->find(Auth::user()->id);

                $usuario->{"posicion"} = $this->getPosicion($correo);

                return response()->json([
                    "success" => true,
                    "errors" => [],
                    "status" => 200,
                    "data" => $usuario
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "errors" => ["Usuario o contraseña incorrectos"],
                    "status" => 500,
                    "data" => []
                ]);
            }
        } else {
          if($user->id_facebook != null){
            $medio = "Facebook";
          }
          if($user->id_google != null){
            $medio = "Google";
          }
            return response()->json([
                "success" => false,
                "errors" => ["Parece que esta cuenta ya ha sido registrada con ".$medio],
                "status" => 200,
                "data" => []
            ]);
        }
    }

    /**
     * Función para logueo de administradores
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginAdmin(Request $request) {
        $correo = $request->input("email");
        $password = $request->input("password");
        $data = null;
        $user = User::where("email", $correo)->first();

        if (isset($user)) {
            if (Auth::once(['email' => $correo, 'password' => $password, 'admin' => 1])) {
                $usuario = User::with('datosUsuario')
                    ->with('codigoGuanajoven')
                    ->find(Auth::user()->id);

                return response()->json([
                    "success" => true,
                    "errors" => [],
                    "status" => 200,
                    "data" => $usuario
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "errors" => ["Usuario o contraseña incorrectos"],
                    "status" => 500,
                    "data" => []
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "errors" => ["Parece que aún no esta registrada esta cuenta"],
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
        $user = User::where("email", $correo)->first();

        if (isset($user) && $user->id_google != null) {
            if (Auth::once(['email' => $correo, 'password' => '_']) && Hash::check($id_google, $user->id_google)) {
                $data = User::with('datosUsuario')
                    ->with('codigoGuanajoven')
                    ->find(Auth::user()->id);

                $data->{"posicion"} = $this->getPosicion($correo);

                return response()->json([
                    "success" => true,
                    "errors" => [],
                    "status" => 200,
                    "data" => $data
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "errors" => ["User o Google incorrectos"],
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
        $user = User::where("email", $correo)->first();

        if (isset($user) && $user->id_facebook != null) {
            if (Auth::once(['email' => $correo, 'password' => '_']) && Hash::check($id_facebook, $user->id_facebook)) {
                $data = User::with('datosUsuario')
                    ->with('codigoGuanajoven')
                    ->find(Auth::user()->id);

                $data->{"posicion"} = $this->getPosicion($correo);


                return response()->json([
                    "success" => true,
                    "errors" => [],
                    "status" => 200,
                    "data" => $data
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    "errors" => ["User o Facebook incorrectos"],
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

    //Función para calcular la posicion de l usuario en la app
    private function getPosicion($correo) {
        $posicion = 1;
        $users = DB::table('usuario')->orderBy('puntaje','desc')->get();

        foreach ($users as $item) {
            if ($item->email == $correo) {
                break;
            }
            $posicion++;
        }

        return $posicion;
    }
}
