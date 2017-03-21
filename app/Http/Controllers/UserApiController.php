<?php

namespace App\Http\Controllers;


use App\Estado;
use App\DatosUsuario;
use App\Genero;
use App\Http\Controllers\Auth\ImageController;
use App\Municipio;
use App\Usuario;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;

class UserApiController extends Controller {
    use AuthenticatesUsers;

    function registrar(Request $request) {
        $errors = [];
        $data = null;

        $reglas = [
            'email' => 'required|email|unique:usuario',
            'password' => 'required|confirmed',
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'genero' => 'required|string',
            'codigo_postal' => 'required|integer|',
            'fecha_nacimiento' => 'required|string',
            'estado_nacimiento' => 'required|string'
        ];
        $input = [
            'email' => $request->input("email"),
            'password' => $request->input("password"),
            'password_confirmation' => $request->input("confirmar_password"),
            'nombre' => $request->input("nombre"),
            'apellido_paterno' => $request->input('apellido_paterno'),
            'genero' => $request->input("genero"),
            'codigo_postal' => $request->input("codigo_postal"),
            'fecha_nacimiento' => $request->input("fecha_nacimiento"),
            'estado_nacimiento' => $request->input("estado_nacimiento")
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
            $id = $usuario->id;
            $nombre = $request->input("nombre");
            $apellido_paterno = $request->input('apellido_paterno');
            $apellido_materno = $request->input('apellido_materno');
            $genero = $request->input("genero");
            $fecha_nacimiento = $request->input("fecha_nacimiento");
            $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $fecha_nacimiento)->toDateString();
            $estado_nacimiento = $request->input("estado_nacimiento");
            $id_ocupacion = $request->input("id_ocupacion");
            $telefono = $request->input("telefono");
            $estado = $request->input("estado");
            $municipio = $request->input("municipio");


            $curp = $this->calcularCurp($apellido_paterno, $apellido_materno, $nombre, $genero, $fecha_nacimiento, $estado);

            if ($curp) {
                $id_estado = "";
                $id_municipio = "";
                $codigo_postal = $request->input("codigo_postal");
                if (isset($codigo_postal)) {
                    $objeto = $this->obtenerEstadoMunicipio($codigo_postal);
                    if ($objeto == false){
                        array_push($errors, "No se pudo verificar tu código postal. Por favor verifica que es correcto.");
                    } else {
                        list($id_estado, $id_municipio) = explode(",", $objeto);
                    }
                }

                if ($id_estado || $id_municipio) {
                    $genero = $request->input("genero");
                    $id_genero = "";
                    if (isset($genero)) {
                        $id_genero = $this->revisarGenero($genero);

                        if ($id_genero == false) {
                            array_push($errors, "No se pudo validar el genero. Por favor verifica tus datos");
                        } else {
                            $id_estado_nacimiento = "";
                            if (isset($estado_nacimiento)) {
                                $id_estado_nacimiento = $this->consultaEstado($estado_nacimiento);

                                if ($id_estado_nacimiento == false) {
                                    array_push($errors, "No se pudo encontrar el estado de nacimiento. Por favor verifica tus datos");
                                } else {
                                    $ruta_imagen = "";
                                    $datos = $request->input('ruta_imagen');
                                    if (isset($datos)) {
                                        $ruta = "storage/usuarios/";
                                        $ruta_imagen = url(ImageController::guardarImagen($datos, $ruta, uniqid("usuario_")));
                                    }

                                    $datosUsuario = DatosUsuario::create([
                                        'id_usuario' => $id,
                                        'nombre' => $nombre,
                                        'apellido_paterno' => $apellido_paterno,
                                        'apellido_materno' => $apellido_materno,
                                        'id_genero' => $id_genero,
                                        'fecha_nacimiento' => $fecha_nacimiento,
                                        'id_estado_nacimiento' => $id_estado_nacimiento,
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
                                            "email" => $usuario->email,
                                            "api_token" => $usuario->api_token,
                                            "id_datos_usuario" => $datosUsuario->id_datos_usuario,
                                            "nombre" => $datosUsuario->nombre,
                                            "apellido_paterno" => $datosUsuario->apellido_paterno,
                                            "apellido_materno" => $datosUsuario->apellido_materno,
                                            "id_genero" => $datosUsuario->id_genero,
                                            "fecha_nacimiento" => $request->input("fecha_nacimiento"),
                                            "id_estado_nacimiento" => $datosUsuario->id_estado_nacimiento,
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
                            }
                        }
                    }
                }
            } else {
                array_push($errors, "No se pudo comprobar tu CURP. Por favor verifica tus datos.");
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

    /* Función para actualizar los datos de un usuario */
    function actualizar(Request $request) {
        $usuario =  Auth::guard('api')->user();
        $data = null;
        $errors = [];

        $reglas = [
            'nombre' => 'required|string',
            'id_genero' => 'required|integer',
            'codigo_postal' => 'required|integer|',
            'apellido_paterno' => 'required|string',
            'curp' => 'required|string',
            'estado_nacimiento' => 'required|string'
        ];
        $input = [
            'nombre' => $request->input("nombre"),
            'id_genero' => $request->input("id_genero"),
            'codigo_postal' => $request->input("codigo_postal"),
            'apellido_paterno' => $request->input('apellido_paterno'),
            'curp' => $request->input("curp"),
            'estado_nacimiento' => $request->input("estado_nacimiento")
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
            $id_estado_nacimiento = $request->input("estado_nacimiento");
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

            $actualiza = DatosUsuario::where("id_usuario", $usuario->id)
                ->update([
                    'nombre' => $nombre,
                    "apellido_paterno" => $apellido_paterno,
                    "apellido_materno" => $apellido_materno,
                    'id_genero' => $id_genero,
                    'fecha_nacimiento' => $fecha_nacimiento,
                    'id_estado_nacimiento' => $id_estado_nacimiento,
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
                    "email" => $usuario->email,
                    "api_token" => $usuario->api_token,
                    "id_datos_usuario" => $datosUsuario->id_datos_usuario,
                    "nombre" => $datosUsuario->nombre,
                    "apellido_paterno" => $datosUsuario->apellido_paterno,
                    "apellido_materno" => $datosUsuario->apellido_materno,
                    "id_genero" => $datosUsuario->id_genero,
                    "fecha_nacimiento" => $datosUsuario->fecha_nacimiento,
                    "id_estado_nacimiento" => $datosUsuario->id_estado_nacimiento,
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

    /* Función para obtener el id_estado mediante su abreviatura */
    private function consultaEstado($abreviatura) {
        $estado = Estado::where("abreviatura", $abreviatura)->first();
        if (isset($estado)) return $estado->id_estado;
        else return false;
    }

    /* Función para obtener estadp y municipio a partir de CP */
    private function obtenerEstadoMunicipio($codigo_postal) {
        $cliente = new Client();
        $respuesta = $cliente->request('GET', 'https://api-codigos-postales.herokuapp.com/v2/codigo_postal/' . $codigo_postal);

        $datos = json_decode($respuesta->getBody());

        $estado = Estado::where("nombre", $datos->estado)->first();
        $municipio = Municipio::where("nombre", $datos->municipio)->first();

        if (isset($estado) && isset($municipio)) return $estado->id_estado . "," . $municipio->id_municipio;
        else return false;
    }

    /* Función que devuelve el id_genero mediante su abreviatura */
    private function revisarGenero($genero) {
        $objetoGenero = Genero::where("abreviatura", $genero)->first();
        if (isset($objetoGenero)) return $objetoGenero->id_genero;
        else return false;
    }

    /* Función que verifica si ya existe el correo en la base de datos */
    public function verificarEmail(Request $request) {
        $correo = Usuario::where("email", $request->email)->first();
        if (isset($correo)) {
            return response()->json([
                "success" => true,
                "errors" => [],
                "status" => 200,
                "data" => true
            ]);
        } else {
            return response()->json([
                "success" => false,
                "errors" => ["Correo no encontrado"],
                "status" => 500,
                "data" => false
            ]);
        }
    }

    /* Función para calcular CURP mediante los datos personales */
    private function calcularCurp($ap_paterno, $ap_materno, $nombre, $genero, $fecha_nac, $estado) {
        list($anio, $mes, $dia) = explode("-", $fecha_nac);

        $data = $ap_paterno{0} . $ap_paterno{1} . $ap_materno{0} . $nombre{0} . $anio . $mes . $dia . $genero . $estado . "RCN" . rand(10, 99);
        $curpBD = DatosUsuario::where("curp", $data)->first();

        if (isset($data) && !isset($curpBD)) return $data;
        else return false;
    }
}