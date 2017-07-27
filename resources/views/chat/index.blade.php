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
            max-width: 20000px;
        }
    </style>
@endsection

@section('contenedor')

    <input type="hidden" id="_url" value="{{url('/')}}">
    <input type="hidden" id="_api_token" value="{{Auth::user()->api_token}}">
    <input type="hidden" id="_active_chat" value="1">
    <div class="row">
        <div class="col s2 list">
            <ul class="collection">
                @foreach($chats as $chat)
                <a href="#!" class="collection-item avatar">
                    <img src="{{$chat->usuario->datosUsuario->ruta_imagen}}" alt="" class="circle">
                    <span class="title">{{$chat->usuario->datosUsuario->nombre}}</span>
                    <p>First Line <br>
                        Second Line
                    </p>
                    <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
                </a>
                @endforeach
            </ul>
        </div>
        <div class="col s9">
            <form id="form_enviar">
                <input id="mensaje" name="mensaje" type="text">   
            </form>
        </div>
            
    </div>

@endsection
