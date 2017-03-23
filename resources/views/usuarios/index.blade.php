@extends('layout.app')

@section('title')
    Usuarios
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/usuarios.js')}}"> </script>
@endsection

@section('cabecera')
    Usuarios
@endsection

@section('contenedor')
    <div class="row">
        <table class="highlight">
            <thead>
            <tr>
                <th data-field="check"></th>
                <th data-field="titulo">Correo</th>
                <th data-field="editar">Editar</th>
                <th data-field="eliminar">Eliminar</th>
            </tr>
            </thead>

            <tbody id="tabla-eventos">

            </tbody>
        </table>
    </div>


    <ul id="pagination-demo" class="pagination-sm"></ul>

    <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Detalles de User</h4>
            <p>
            <div class="row">
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="correo" type="text" class="vald">
                            <label for="correo">Correo</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="pass" type="password" class="vald">
                            <label for="pass">Nueva Contraseña</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="pass2" type="password" class="vald">
                            <label for="pass2">Confirmar contraseña</label>
                        </div>
                    </div>

                </form>
            </div>
            </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action waves-effect waves-green btn-flat" id="guardar-evento">Guardar</a>
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
        </div>
    </div>
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h4>Confirmar</h4>
            <p id="delete-message">¿Desea eliminar el evento seleccionado?</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="waves-effect waves-red btn-flat" onclick="$('#md1').closeModal(); return false;">Cancelar</a>
            <a href="#" class="waves-effect waves-green btn-flat" onclick="deleteEvents()" id="md1_YesBtn">Sí</a>
        </div>
    </div>
    <div class="fixed-action-btn" style="bottom: 10px; right: 24px;">
        <a href="#modal1" class="btn-floating btn-large waves-effect waves-light rose_code btn modal-trigger" style="background: #BF3364;">
            <i class="material-icons" id="new-event">add</i>
        </a>
    </div>
    <div class="fixed-action-btn" id="delete-selection" style="display:none; bottom: 10px; right: 100px;">
        <a class="btn-floating btn-large waves-effect waves-light rose-code btn" style="background: #BF3364;">
            <i class="material-icons" id="new-event">delete</i>
        </a>
    </div>
@endsection