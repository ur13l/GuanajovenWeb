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
        #container {
            margin: 0px !important;
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

  <h4>CHAT</h4>
  <form id="form_enviar">
    <input id="mensaje" name="mensaje" type="text">   
  </form>
  
    <div class="fixed-action-btn" style="bottom: 10px; right: 24px;">
        <a href="{{url('convocatorias/nueva')}}" class="btn-floating btn-large waves-effect waves-light btn modal-trigger"
            style="background: #BF3364;">
            <i class="material-icons" id="new-Pub">add</i>
        </a>
    </div>


@endsection
