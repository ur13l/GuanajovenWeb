<?php

namespace App\Http\Controllers;


use App\LoginToken;
use Illuminate\Http\Request;

class NotificacionesController {

    public function index(Request $request) {
        return view('notificaciones.index');
    }

    /**
     * Función para guardar un nuevo token de dispositivo
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrar(Request $request) {
        $id_usuario = $request->input('id_usuario');
        $device_token = $request->input('device_token');

        $objetoUsuarioToken = LoginToken::updateOrCreate(
            ['id_usuario' => $id_usuario, 'device_token' => $device_token],
            ['id_usuario' => $id_usuario, 'device_token' => $device_token]
        );

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
                "errors" => ["¡Ops!, ocurrio un error al registrar el token"],
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
        $id_device_token = $request->input('id_device_token');

        $objetoUsuarioToken = LoginToken::find($id_device_token);

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
                "errors" => ["¡Ops!, ocurrio un problema al eliminar el token"],
                "status" => 500,
                "data" => false
            ]);
        }
    }
}