<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;
use App\Mensaje;
use App\LoginToken;
use App\Events\ChatEvent;
use App\Utils\NotificationsUtils;
use Illuminate\Support\Facades\Auth;
use LRedis;

class ChatApiController extends Controller
{

    public function enviar(Request $request) {
        $user = Auth::guard('api')->user();
        $chat = Chat::where('id_usuario', $user->id)->get()->first();
        if(!isset($chat)) {
            $chat = Chat::create(array(
                'id_usuario' => $user->id
            ));
        }

        $mensaje = Mensaje::create(array(
            'id_chat' => $chat->id_chat,
            'mensaje' => $request->mensaje,
            'envia_usuario' => true,
            'visto' => false
        ));

        $tokens = LoginToken::where('os', 'web')->pluck('device_token')->toArray();
        //Generación del mensaje.
                $message = array(
                    'title' => "Nuevo mensaje",
                    'body' => $mensaje->mensaje,
                    'link_url' => "chat",
                    'sound' => 'default',
                    'priority' => 'high',
                    'category' => 'URL_CATEGORY',
                    'tag' => "chat");
        NotificationsUtils::sendNotification($tokens, $message, 'data');

        $redis = LRedis::connection();
        $msArray = array(
            "id_chat" => $chat->id_chat,
            "mensaje" => $mensaje->mensaje
        );
        $redis->publish('message', json_encode($msArray));
        return response()->json(array(
            'success' => true,
            'status' => 200,
            'data' => true,
            'errors' => []
        ));
    }

    public function mensajes (Request $request) {
        $user = Auth::guard('api')->user();
        $chat = Chat::where('id_usuario', $user->id)->get()->first();
        return response()->json(
            array(
                'success' => true,
                'status' => 200,
                'errors' => [],
                'data' => $chat->mensajes()->orderBy('created_at', 'desc')->paginate(20)
            )
        );

    }

     public function mensajesAdmin (Request $request) {
        $user = Auth::guard('api')->user();
        $chat = Chat::find($request->id_chat);
        return response()->json(
             $chat->mensajes()->orderBy('created_at', 'desc')->paginate(20)
            );

    }



    
    public function enviarAdmin(Request $request) {
        $user = Auth::guard('api')->user();
        $chat = Chat::find($request->active_chat);

        $mensaje = Mensaje::create(array(
            'id_chat' => $chat->id_chat,
            'mensaje' => $request->mensaje,
            'envia_usuario' => false,
            'visto' => false
        ));

        $tokens = LoginToken::where('id_usuario', $chat->id_usuario)->pluck('device_token')->toArray();


        //Generación del mensaje.
                $message = array(
                    'title' => "Nuevo mensaje",
                    'body' => $request->mensaje,
                    'link_url' => "chat",
                    'sound' => 'default',
                    'priority' => 'high',
                    'category' => 'URL_CATEGORY',
                    'content_available' => true,
                    'tag' => "chat");


  $dispositivo = LoginToken::where('device_token',$tokens[0])->get()->first();


    if($dispositivo->os == "ios"){
       NotificationsUtils::sendNotification($tokens, $message, 'notification');
    }else{
      NotificationsUtils::sendNotification($tokens, $message, 'data');
    }

        return response()->json(array(
            'success' => true,
            'status' => 200,
            'data' => true,
            'errors' => []
        ));
    }
}
