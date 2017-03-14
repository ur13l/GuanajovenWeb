@extends('layout.app')

@section('title')
    Nueva Convocatoria
@endsection

@section('cabecera')
    Convocatorias
@endsection

@section('contenedor')
    <div class="row">
        <h2>Nueva Convocatoria</h2>
    </div>
    <div class="row">
        <form class="col s12">
            <div class="row">
                <div class="input-field col s6">
                    <input id="titulo" type="text" class="validate">
                    <label for="titulo">Título</label>
                </div>
                <div class="input-field col s6">
                    <input id="fecha_ape" type="date" class="datepicker">
                    <label for="fecha_ape">Fecha de Apertura</label>
                </div>
            </div>
            <div class="row">
                <div class="file-field input-field col s6">
                    <div class="btn" style="background: #BF3364;">
                        <span>Imagen</span>
                        <input type="file" multiple>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Subir imagen">
                    </div>
                </div>
                <div class="input-field col s6">
                    <input id="fecha_cie" type="date" class="datepicker">
                    <label for="fecha_cie">Fecha de Cierre</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <textarea id="descripcion" class="materialize-textarea"></textarea>
                    <label for="descripcion">Descripción</label>
                </div>
            </div>
            <div class="row" style="padding-left: 1%;">
                <a href="http://jovenes.guanajuato.gob.mx/news/" style="background: #BF3364;" class="waves-effect waves-light btn">
                    <i class="material-icons left">receipt</i>Documentos
                </a>
            </div>
        </form>
    </div>
@endsection