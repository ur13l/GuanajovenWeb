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
        <div class="col s4 list">
            <div class="collection" id="lista-chats">
                @foreach($chats as $chat)        
                <a href="#!" class="collection-item avatar chat-item">

                <input type="hidden" value="{{$chat->id_chat}}" id="chat{{$chat->id_chat}}"> 
                        <img src="{{$chat->usuario->datosUsuario->ruta_imagen}}" alt="" class="circle">
                   
                    <span  class="title accent-color-text">{{$chat->usuario->datosUsuario->nombre}}</span>
                    <p class="grey-text">
                    {{$chat->ultimoMensaje()->mensaje}}
                    </p>
                    <p class="grey-text secondary-content" style="margin-top:-5px" href="#!">{{
                        $chat->ultimoMensaje()->created_at->format('d/m/Y') == \Carbon\Carbon::now("America/Mexico_City")->format('d/m/Y') ?
                        $chat->ultimoMensaje()->created_at->format('H:i') :
                        $chat->ultimoMensaje()->created_at->format('d/m/Y') 
                        }}</p>
                    @if( $chat->contarNoLeidos() > 0 )
                        <p href="#!"  class="secondary-content primary-color-text"><span style="margin-top:25px" class="badge">{{$chat->contarNoLeidos()}}</span></p>
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
