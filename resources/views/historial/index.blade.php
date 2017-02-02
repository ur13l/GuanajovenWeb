@extends('layout.app')

@section('title')
    Historial de Notificaciones
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/notificaciones.js')}}"> </script>
@endsection

@section('cabecera')
    Historial
@endsection

@section('contenedor')
    <div class="row">
        <h5 class="col s12">Notificaciones enviadas</h5>

        <table class="highlight">
            <thead>
            <tr>
                <th data-field="check"></th>
                <th data-field="titulo">Título</th>
                <th data-field="mensaje">Mensaje</th>
                <th data-field="fecha">Fecha</th>
                <th data-field="eliminar">Eliminar</th>

            </tr>
            </thead>

            <tbody id="tabla-notificaciones">

            </tbody>
        </table>
    </div>
    <ul id="pagination-demo" class="pagination-sm"></ul>

    <div class="row">
        <!-- Modal Structure -->
        <div id="modal1" class="modal col s12 m8 l4 offset-m2 offset-l4">

            <div class="modal-content">
                <h4 class="blue-code-text">Personalizar destinatarios</h4>
                <p>
                <div class="row">
                    <h6 class="col s12"> Por género </h6>
                    <div class="input-field col s6">
                        <input type="checkbox" id="chk_hombre" class="filled-in checkbox-green-code" checked>
                        <label for="chk_hombre">Hombres</label>
                    </div>
                    <div class="input-field col s6">
                        <input type="checkbox" id="chk_mujer" class="filled-in checkbox-green-code" checked>
                        <label for="chk_mujer">Mujeres</label>
                    </div>
                </div>
                <div class="row">
                    <h6 class="col s12"> Condiciones especiales </h6>
                    <div class="input-field col s4">
                        <input type="checkbox" id="chk_presion" class="filled-in checkbox-green-code" checked>
                        <label for="chk_presion">Presión elevada</label>
                    </div>
                    <div class="input-field col s4">
                        <input type="checkbox" id="chk_glucosa" class="filled-in checkbox-green-code" checked>
                        <label for="chk_glucosa">Glucosa elevada</label>
                    </div>

                    <div class="input-field col s4">
                        <input type="checkbox" id="chk_lesion" class="filled-in checkbox-green-code" checked>
                        <label for="chk_lesion">Lesionado</label>
                    </div>
                </div>
                <div class="row">
                    <h6 class="col s12"> Por rango de edad </h6>
                    <div class="input-field col s5">
                        <select required id="sl_rango_edad" class="validate blue-code-text">
                            <option value="" disabled>Elige una opción</option>
                            <option value="1" selected>Todos</option>
                            <option value="2">Entre</option>
                            <option value="3">Mayores de </option>
                            <option value="4">Menores de </option>
                        </select>
                    </div>

                    <div class="input-field col s2">
                        <input type="number" id="txt_age1" style="display:none" name="name" value="">
                    </div>
                    <div class="input-field col s2">
                        <input type="number" id="txt_age2" style="display:none" name="name" value="">
                    </div>
                    <p class="col s2" id="label_age" style="display:none"> años </p>
                </div>
                <div class="row">
                    <h6 class="col s12"> Por IMC </h6>
                    <div class="input-field col s12">
                        <div id="imc_range" class="noUi-target noUi-ltr noUi-horizontal noUi-background">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <h6 class="col s12"> Sistema operativo </h6>
                    <div class="input-field col s6">
                        <input type="checkbox" id="chk_android" class="filled-in checkbox-green-code" checked>
                        <label for="chk_android">Android</label>
                    </div>
                    <div class="input-field col s6">
                        <input type="checkbox" id="chk_ios" class="filled-in checkbox-green-code" checked>
                        <label for="chk_ios">iOS</label>
                    </div>
                </div>
                </p>
            </div>
            <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</a>

            </div>
        </div>
    </div>
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h4>Confirmar</h4>
            <p id="delete-message">¿Desea eliminar el evento seleccionado?</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="waves-effect waves-green btn-flat" onclick="$('#deleteModal').closeModal(); return false;">Cancelar</a>
            <a href="#" class="waves-effect waves-green btn-flat" onclick="deleteNotifications()" id="md1_YesBtn">Sí</a>
        </div>
    </div>

    <div class="fixed-action-btn" id="delete-selection" style="display:none; bottom: 10px; right: 100px;">
        <a class="btn-floating btn-large waves-effect waves-light green-code btn" >
            <i class="material-icons" id="new-event">delete</i>
        </a>
    </div>
@endsection