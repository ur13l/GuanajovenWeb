@extends('layout.app')

@section('title')
    Nuevo Evento
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/eventos.js')}}"> </script>
@endsection

@section('cabecera')
    Eventos
@endsection

@section('contenedor')
    <div class="row">
        <h2>Nuevo Evento</h2>
    </div>
    <div class="row" style="height: 350px;">
        <div id="map" style="height: 100%;"></div>
    </div>
    <div class="row">
        <form class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <input id="titulo" type="text" class="vald">
                    <label for="titulo">Título</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="descripcion" class="materialize-textarea vald"></textarea>
                    <label for="descripcion">Descripción</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s6">
                    <input id="fecha-inicio" type="text" class="datepicker vald" >
                    <label for="fecha-inicio">Fecha de inicio</label>
                </div>
                <div class="input-field col s6">
                    <input id="hora-inicio" type="text" class="timepicker vald">
                    <label for="hora-inicio">Hora de inicio</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input id="fecha-fin" type="text" class="datepicker vald">
                    <label for="fecha-fin">Fecha de finalización</label>
                </div>
                <div class="input-field col s6">
                    <input id="hora-fin" type="text" class="timepicker vald">
                    <label for="hora-fin">Hora de finalización</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select required id="tipo-evento" class="validate">
                        <option value="" disabled selected>Elige una opción</option>
                        @foreach($tipos as $tipo)
                            <option value="{{$tipo->id_tipo_evento}}">{{$tipo->nombre}}</option>
                        @endforeach
                    </select>
                    <label>Tipo de evento</label>
                </div>
            </div>
        </form>
        <div class="row">
            <button class="waves-effect waves-light btn rose-code" id="guardar-n-evento" style="background: #BF3364;">
                <i class="material-icons left">library_books</i>Guardar</button>
        </div>
    </div>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 23.36715613998013, lng: -102.33970642089844},
                zoom: 8
            });

            map.addListener('click', function (e) {
                ponerMarca(e.latLng, map);
            });
        }

        function ponerMarca(latLng, map) {
            var marca = new google.maps.Marker({
                position: latLng,
                map: map
            });
            map.panTo(latLng);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHm6Cez6yYXKGHBxPBGFZtFUuJ_O8FOwI&callback=initMap"
            async defer></script>
@endsection
