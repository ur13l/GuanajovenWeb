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
        <form class="col s12" action="{{ url('/eventos/guardar') }}" method="post">
            <input type="hidden" id="posicion" name="posicion" value="">
            <div class="row">
                <div class="input-field col s12">
                    <input id="titulo" type="text" class="vald" name="titulo" required>
                    <label for="titulo">Título</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="descripcion" class="materialize-textarea vald" name="descripcion" maxlength="200" required></textarea>
                    <label for="descripcion">Descripción</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s6">
                    <input id="fecha-inicio" type="text" class="datepicker vald" name="fecha_inicio" required>
                    <label for="fecha-inicio">Fecha de inicio</label>
                </div>
                <div class="input-field col s6">
                    <input id="hora-inicio" type="text" class="timepicker vald" name="hora_inicio" required>
                    <label for="hora-inicio">Hora de inicio</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input id="fecha-fin" type="text" class="datepicker vald" name="fecha_fin" required>
                    <label for="fecha-fin">Fecha de finalización</label>
                </div>
                <div class="input-field col s6">
                    <input id="hora-fin" type="text" class="timepicker vald" name="hora_fin" required>
                    <label for="hora-fin">Hora de finalización</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input type="number" class="vald" id="puntos-otorgados" name="puntos-otorgados" required>
                    <label for="puntos-otorgados">Puntos otorgados</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" class="vald" id="area-responsable" name="area-responsable" required>
                    <label for="area-responsable">Área responsable</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select required id="tipo-evento" name="tipo-evento" class="validate" onchange="$('#tipo-seleccionado').val($('#tipo-evento').val());">
                        <option value="" disabled selected>Elige una opción</option>
                        @foreach($tipos as $tipo)
                            <option value="{{$tipo->id_tipo_evento}}">{{$tipo->nombre}}</option>
                        @endforeach
                    </select>
                    <label>Tipo de evento</label>
                    <input type="hidden" name="tipo-seleccionado" value="" id="tipo-seleccionado">
                </div>
            </div>
            <div class="row">
                <button type="submit" class="waves-effect waves-light btn rose-code" id="guardar-evento" style="background: #BF3364;">
                    <i class="material-icons left">library_books</i>Guardar
                </button>
            </div>
        </form>
    </div>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 23.36715613998013, lng: -102.33970642089844},
                zoom: 8
            });
            var infoWindow = new google.maps.InfoWindow;
            var marca = null;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    infoWindow.setPosition(pos);
                    marca = new google.maps.Marker({
                        position: pos,
                        map: map,
                        draggable: true,
                        title: 'Evento'
                    });
                    map.setCenter(pos);
                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }

            map.addListener('mouseout', function() {
                $('#posicion').val(marca.getPosition());
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHm6Cez6yYXKGHBxPBGFZtFUuJ_O8FOwI&callback=initMap"
            async defer></script>
@endsection
