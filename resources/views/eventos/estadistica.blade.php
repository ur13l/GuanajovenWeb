@extends('layout.app')

@section('title')
    Eventos
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/eventos.js')}}"> </script>
@endsection

@section('cabecera')
    Eventos
@endsection

@section('contenedor')
    <div class="row">
        <h2>{{ $titulo }}</h2>
    </div>
    <div class="row">

    </div>
@endsection
