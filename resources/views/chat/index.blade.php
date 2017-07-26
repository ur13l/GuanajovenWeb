@extends('layout.app')

@section('title')
    Chat
@endsection

@section('cabecera')
    Chat
@endsection

@section('head')
    <script src="{{url('/js/convocatorias/index.js')}}"></script>
@endsection

@section('contenedor')
    <!--Modal eliminar-->

    <div class="row">

  <h4>CHAT</h4>
    <div class="fixed-action-btn" style="bottom: 10px; right: 24px;">
        <a href="{{url('convocatorias/nueva')}}" class="btn-floating btn-large waves-effect waves-light btn modal-trigger"
            style="background: #BF3364;">
            <i class="material-icons" id="new-Pub">add</i>
        </a>
    </div>


@endsection
