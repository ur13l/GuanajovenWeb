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
                    <select required id="tipo" class="validate">
                        <option value="" disabled>Elige una opción</option>
                        <option value="1" selected>Competencia de deportista olímpico</option>
                        <option value="2">Información general</option>
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
@endsection