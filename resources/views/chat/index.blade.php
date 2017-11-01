@extends('layout.app')

@section('title')
    Chat
@endsection

@section('cabecera')
    Chat
@endsection

@section('head')
    <script src="{{url('/js/chat/index.js')}}"></script>
    <style>
        /**
        Esta configuración solo aplica en la ventana de chat, ya que esta tiene una estructura diferente.
        **/
        #container {
            margin-top: 64px !important;
            padding: 0px !important;
            width: 100%;
            height:100%;
            max-width: 20000px;
        }

        ::-webkit-scrollbar {
            display: none;
        }
        nav {
            position: fixed;
            top: 0;
            z-index: 1000;
        }
    </style>
    <link href="{{url('/css/chat.css')}}" rel="stylesheet">
    <link rel="manifest" href="{{url('/manifest.json')}}">


@endsection

@section('contenedor')

    <input type="hidden" id="_url" value="{{url('/')}}">
    <input type="hidden" id="_api_token" value="{{Auth::user()->api_token}}">
    <input type="hidden" id="_active_chat" value="1">
    <div class="row">
        <div class="col s4 list" id="contenedor_izq">
            <div class="buscarUsuarioDiv">
                <input type="text" name="" id="buscarUsuarios">
            </div>
            <div class="collection" id="lista-chats">
                @foreach($chats as $chat)
                <a href="#!" class="collection-item avatar chat-item">

                <input type="hidden" value="{{$chat['chat']->id_chat}}" id="chat{{$chat['chat']->id_chat}}">
                        <img src="{{$chat['chat']->usuario->datosUsuario->ruta_imagen}}" alt="" class="circle">

                    <span  class="title accent-color-text">{{$chat['chat']->usuario->datosUsuario->nombre}}</span>
                    <p class="grey-text">
                    @if( $chat['chat']->ultimoMensaje() )
                        {{$chat['chat']->ultimoMensaje()->mensaje}}
                    @endif
                    </p>
                    <p class="grey-text secondary-content" style="margin-top:-5px" href="#!">
                    @if( $chat['chat']->ultimoMensaje() )
                        {{
                        $chat['chat']->ultimoMensaje()->created_at->format('d/m/Y') == \Carbon\Carbon::now("America/Mexico_City")->format('d/m/Y') ?
                        $chat['chat']->ultimoMensaje()->created_at->format('H:i') :
                        $chat['chat']->ultimoMensaje()->created_at->format('d/m/Y')
                        }}
                    @endif
                    </p>
                    @if( $chat['chat']->contarNoLeidos() > 0 )
                        <p href="#!"  class="secondary-content primary-color-text"><span style="margin-top:25px" class="badge">{{$chat['chat']->contarNoLeidos()}}</span></p>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
            <div class="grey-color lienzo">
                <ul id="lista-mensajes" style="overflow: auto">

                </ul>
                <div class="campo-mensaje">
                    <form id="form_enviar">
                        <input id="mensaje" name="mensaje" value="" type="text">
                        <input id="enviarMensaje" class="mensaje-izquierda primary-color" type="submit" value="Enviar">
                    </form>
                </div>
            </div>

        </div>
             <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
    <script>
        var socket = io("{{env('SOCKET_URL')}}");
        socket.on("message", function(message){
            console.log("MENSAJE NUEVo");
            mensaje = JSON.parse(message)
            if(mensaje.id_chat == $("#_active_chat").val()) {
                $("#lista-mensajes").append("<li class='mensaje-izquierda primary-color'>" +  mensaje.mensaje  + "</li>");
            }
        });
    </script>

@endsection
