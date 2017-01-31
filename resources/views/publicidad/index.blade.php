@extends('layout.app')

@section('title')
    Publicidad
@endsection
@section('contenedor')
    <div class="row">
        <div class="col s12 m4 l4 anuncio" id="ejemplo1">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/convocatorias/ejemplo1.png')}}">
                    <span class="card-title" style="background: black;">Ejemplo 1</span>
                    <a class="btn-floating halfway-fab waves-effect waves-light red right deleteP"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4 anuncio" id="ejemplo2">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/convocatorias/ejemplo2.png')}}">
                    <span class="card-title" style="background: black;">Ejemplo 2</span>
                    <a class="btn-floating halfway-fab waves-effect waves-light red right deleteP"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4 anuncio" id="ejemplo3">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/convocatorias/ejemplo3.png')}}">
                    <span class="card-title" style="background: black;">Ejemplo 3</span>
                    <a class="btn-floating halfway-fab waves-effect waves-light red right deleteP"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row" align="center">
        <div class="col s12 m4 l4 anuncio" id="ejemplo4">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/convocatorias/ejemplo4.jpg')}}">
                    <span class="card-title" style="background: black;">Ejemplo 4</span>
                    <a class="btn-floating halfway-fab waves-effect waves-light red right deleteP"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4 anuncio" id="ejemplo5">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/convocatorias/ejemplo5.jpg')}}">
                    <span class="card-title" style="background: black;">Ejemplo 5</span>
                    <a class="btn-floating halfway-fab waves-effect waves-light red right deleteP"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4 anuncio" id="ejemplo6">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/convocatorias/ejemplo6.jpg')}}">
                    <span class="card-title" style="background: black;">Ejemplo 6</span>
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
                        <div class="input-field col s12">
                            <input id="titulo" type="text" class="vald">
                            <label for="titulo">Título</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field col s6">
                            <div class="btn" style="cursor: pointer;">
                                <span>Imagen</span>
                                <input type="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input type="file-path validate" type="text">
                            </div>
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