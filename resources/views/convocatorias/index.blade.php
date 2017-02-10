@extends('layout.app')

@section('title')
    Convocatorias
@endsection

@section('contenedor')
    <div class="row">
        <h1>Convocatorias</h1>
    </div>

    <!--Modal eliminar-->
    <div id="deleteModalConv" class="modal">
        <div class="modal-content">
            <h4>Confirmar</h4>
            <p id="delete-message">¿Desea eliminar la convocatoria?</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="waves-effect waves-red btn-flat" onclick="$(this).parent().parent().closeModal();">Cancelar</a>
            <a href="#" class="waves-effect waves-green btn-flat" onclick="" id="mdConv_YesBtn">Sí</a>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m4 l4 anuncio" id="ejemplo1">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/convocatorias/ejemplo1.png')}}">
                    <span class="card-title" style="background: black;">Ejemplo 1</span>
                    <a href="#deleteModalConv" class="btn-floating halfway-fab waves-effect waves-light red right deleteP modal-trigger"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4 anuncio" id="ejemplo2">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/convocatorias/ejemplo2.png')}}">
                    <span class="card-title" style="background: black;">Ejemplo 2</span>
                    <a href="#deleteModalConv" class="btn-floating halfway-fab waves-effect waves-light red right deleteP modal-trigger"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4 anuncio" id="ejemplo3">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/convocatorias/ejemplo3.png')}}">
                    <span class="card-title" style="background: black;">Ejemplo 3</span>
                    <a href="#deleteModalConv" class="btn-floating halfway-fab waves-effect waves-light red right deleteP modal-trigger"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m4 l4 anuncio" id="ejemplo4">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/convocatorias/ejemplo4.png')}}">
                    <span class="card-title" style="background: black;">Ejemplo 4</span>
                    <a href="#deleteModalConv" class="btn-floating halfway-fab waves-effect waves-light red right deleteP modal-trigger"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4 anuncio" id="ejemplo5">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/convocatorias/ejemplo5.png')}}">
                    <span class="card-title" style="background: black;">Ejemplo 5</span>
                    <a href="#deleteModalConv" class="btn-floating halfway-fab waves-effect waves-light red right deleteP modal-trigger"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4 anuncio" id="ejemplo6">
            <div class="card">
                <div class="card-image">
                    <img src="{{url('img/convocatorias/ejemplo6.png')}}">
                    <span class="card-title" style="background: black;">Ejemplo 6</span>
                    <a href="#deleteModalConv" class="btn-floating halfway-fab waves-effect waves-light red right deleteP modal-trigger"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed-action-btn" style="bottom: 10px; right: 24px;">
        <a href="{{url('convocatorias/nueva_convocatoria')}}" class="btn-floating btn-large waves-effect waves-light btn modal-trigger"
            style="background: #BF3364;">
            <i class="material-icons" id="new-Pub">add</i>
        </a>
    </div>


@endsection