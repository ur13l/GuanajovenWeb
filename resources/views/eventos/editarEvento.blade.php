@extends('layout.app')

@section('title')
    Eventos
@endsection

@section('cabecera')
    Eventos
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/eventos.js')}}"> </script>

@endsection

@section('contenedor')
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('mapa_evento'), {
                center: {lat: -34.397, lng: 150.644},
                scrollwheel: false,
                zoom: 8
            });
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBj2RIXuHivK_9TFIdJ7-5akys3yskX5K4&callback=initMap"
            async defer></script>

    <div class="row">
        <h2>Detalles del Evento</h2>
    </div>
    <div class="row">
        <div id="mapa_evento"></div>
    </div>
@endsection