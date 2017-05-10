<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacionesApiController extends Controller
{
    /**
     * Notificación: RegistrarToken
     * params: [id_usuario, device_token, os]
     * Función para guardar un nuevo token de dispositivo y asociarlo a una cuenta de usuario.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrar(Request $request) {
        $id_usuario = $request->input('id_usuario');
        $device_token = $request->input('device_token');
        $os = $request->input('os');

        $objetoUsuarioToken = LoginToken::create($request->all());

        if (isset($objetoUsuarioToken)) {
            return response()->json([
                "success" => true,
                "errors" => [],
                "status" => 200,
                "data" => true
            ]);
        } else {
            return response()->json([
                "success" => false,
                "errors" => ["Ocurrio un error al registrar el token"],
                "status" => 500,
                "data" => false
            ]);
        }

    }

    /**
     * Función para eliminar un token de dispositivo de la base de datos
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelar(Request $request) {
        $id_device_token = $request->input('device_token');

        $objetoUsuarioToken = LoginToken::where('device_token', $id_device_token)->get()->first();

        if (isset($objetoUsuarioToken)) {
            $objetoUsuarioToken->delete();

            return response()->json([
                "success" => true,
                "errors" => [],
                "status" => 200,
                "data" => true
            ]);
        } else {
            return response()->json([
                "success" => false,
                "errors" => ["Ocurrio un problema al eliminar el token"],
                "status" => 500,
                "data" => false
            ]);
        }
    }
}
