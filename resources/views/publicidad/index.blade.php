@extends('layout.app')

@section('title')
    Publicidad
@endsection
@section('contenedor')
    <div class="row">
        <h1>Publicidad</h1>
    </div>
    <div class="row">
        <div class="col s12 m12 l12 anuncio" id="ejemplo1">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/publicidad/ejemplo1.jpg')}}">
                    <span class="card-title" style="background: black; width: 25%;">Ejemplo 1</span>
                    <a class="btn-floating halfway-fab waves-effect waves-light red right deleteP"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l12 anuncio" id="ejemplo2">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/publicidad/ejemplo2.jpg')}}">
                    <span class="card-title" style="background: black; width: 25%;">Ejemplo 2</span>
                    <a class="btn-floating halfway-fab waves-effect waves-light red right deleteP"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l12 anuncio" id="ejemplo3">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/publicidad/ejemplo3.jpg')}}">
                    <span class="card-title" style="background: black; width: 25%;">Ejemplo 3</span>
                    <a class="btn-floating halfway-fab waves-effect waves-light red right deleteP"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m12 l12 anuncio" id="ejemplo4">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/publicidad/ejemplo4.jpg')}}">
                    <span class="card-title" style="background: black; width: 25%;">Ejemplo 4</span>
                    <a class="btn-floating halfway-fab waves-effect waves-light red right deleteP"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l12 anuncio" id="ejemplo5">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/publicidad/ejemplo5.jpg')}}">
                    <span class="card-title" style="background: black; width: 25%;">Ejemplo 5</span>
                    <a class="btn-floating halfway-fab waves-effect waves-light red right deleteP"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l12 anuncio" id="ejemplo6">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/publicidad/ejemplo6.jpg')}}">
                    <span class="card-title" style="background: black; width: 25%;">Ejemplo 6</span>
                    <a class="btn-floating halfway-fab waves-effect waves-light red right deleteP"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
    </div>

    <!--Modal Agregar-->
    <div id="modalPub" class="modal">
        <div class="modal-content">
            <h4>Nueva Publicidad</h4>
            <p>
            <div class="row">
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="titulo" type="text" class="vald">
                            <label for="titulo">Título</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="url" type="text" class="vald">
                            <label for="url">URL</label>
                        </div>
                    </div>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Imagen</span>
                            <input type="file" multiple>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Subir imagen">
                        </div>
                    </div>
                </form>
            </div>
            </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action waves-effect waves-green btn-flat" id="guardar-pub">Guardar</a>
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
        </div>
    </div>

    <div class="fixed-action-btn" style="bottom: 10px; right: 24px;">
        <a href="#modalPub" class="btn-floating btn-large waves-effect waves-light btn modal-trigger" style="background: #BF3364;">
            <i class="material-icons" id="new-Pub">add</i>
        </a>
    </div>
@endsection