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
            margin: 0px !important;
            padding: 0px !important;
            width: 100%;
            height:100%;
            max-width: 20000px;
        }
    </style>
    <link href="{{url('/css/chat.css')}}" rel="stylesheet">
@endsection

@section('contenedor')

    <input type="hidden" id="_url" value="{{url('/')}}">
    <input type="hidden" id="_api_token" value="{{Auth::user()->api_token}}">
    <input type="hidden" id="_active_chat" value="1">
    <div class="row">
        <div class="col s4 list">
            <div class="collection">
                @foreach($chats as $chat)        
                <a href="#!" class="collection-item avatar chat-item">

                <input type="hidden" value="{{$chat->id_chat}}" id="chat{{$chat->id_chat}}"> 
                        <img src="{{$chat->usuario->datosUsuario->ruta_imagen}}" alt="" class="circle">
                   
                    <span  class="title accent-color-text">{{$chat->usuario->datosUsuario->nombre}}</span>
                    <p class="grey-text">
                    {{$chat->ultimoMensaje()->mensaje}}
                    </p>
                    <p class="grey-text secondary-content" style="margin-top:-5px" href="#!">{{$chat->ultimoMensaje()->created_at->format('d/m/Y')}}</p>
                    @if( $chat->contarNoLeidos() > 0 )
                        <p href="#!"  class="secondary-content primary-color-text"><span style="margin-top:25px" class="badge">{{$chat->contarNoLeidos()}}</span></p>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
            <div class="primary-color lienzo">

            </div>
            <div class="campo_mensaje">
                <form id="form_enviar">
                    <input id="mensaje" name="mensaje" type="text">   
                </form>
            </div>
        </div>
            

@endsection
