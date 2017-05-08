@extends('layout.app')

@section('title')
    Notificaciones
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/notificaciones/index.js')}}"> </script>
@endsection

@section('cabecera')
    Notificaciones
@endsection

@section('contenedor')
    <form action="/notificacion/enviar" method="post">
        <div class="row">
            <h5>Nueva notificación</h5>
            <div class="input-field col s12">
                <input placeholder="Título" name="titulo" id="titulo" type="text" maxlength="50" class="validate">
                <label for="titulo" data-error="Este campo es obligatorio">Título</label>
            </div>
            <div class="input-field col s12">
                <textarea id="mensaje" name="mensaje" class="materialize-textarea " maxlength="2000"></textarea>
                <label for="mensaje" data-error="Este campo es obligatorio">Mensaje</label>
            </div>
            <div class="input-field col s12">
                <input placeholder="Enlace (Opcional)" name="enlace" id="enlace" type="text" class="validate">
                <label for="enlace" data-error="Este campo es obligatorio">Enlace(Opcional)</label>
            </div>
        </div>
        <div class="hidden advanced">
            <div class="row">
                <div class="col s12 m6">
                <h6 class="col s12 "> Por género </h6>
                <div class="input-field col s12">
                    <input type="checkbox" id="chk_hombre" name="chk_hombre" class="filled-in checkbox-accent-color" checked>
                    <label for="chk_hombre">Hombres</label>
                </div>
                <div class="input-field col s12">
                    <input type="checkbox" id="chk_mujer" name="chk_mujer" class="filled-in checkbox-accent-color" checked>
                    <label for="chk_mujer">Mujeres</label>
                </div>
                </div>

            <div class="col s12 m6">
                <h6 class="col s12 m6"> Sistema operativo </h6>
                <div class="input-field col s12">
                    <input type="checkbox" id="chk_android" name="chk_android" class="filled-in checkbox-accent-color" checked>
                    <label for="chk_android">Android</label>
                </div>
                <div class="input-field col s12">
                    <input type="checkbox" id="chk_ios" name="chk_ios" class="filled-in checkbox-accent-color" checked>
                    <label for="chk_ios">iOS</label>
                </div>

            </div>
            </div>
        </div>

        <div class="row">
            <h6 class="col s12"> Por rango de edad </h6>
            <div class="input-field col s5">
                <select required id="sl_rango_edad" name="sl_rango_edad" class="validate primary-color-text">
                    <option value="" disabled>Elige una opción</option>
                    <option value="1" selected>Todos</option>
                    <option value="2">Entre</option>
                    <option value="3">Mayores de </option>
                    <option value="4">Menores de </option>
                </select>
            </div>

            <div class="input-field col s2">
                <input type="number" id="txt_age1" style="display:none" name="txt_age1" value="">
            </div>
            <div class="input-field col s2">
                <input type="number" id="txt_age2" style="display:none" name="txt_age2" value="">
            </div>
            <p class="col s2" id="label_age" style="display:none"> años </p>
        </div>


        <div class="row right">
            <button class="waves-effect waves-light btn accent-color" href="#modal1" ><i class="material-icons left">settings</i>Configurar Destinatarios</button>
            <button type="submit" class="waves-effect waves-light btn accent-color" id="enviar"><i class="material-icons left">send</i>Enviar</button>

        </div>
    </form>


    <!-- Lógica para mostrar notificaciones -->
    <div class="row" style="margin-top:110px">
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
    </div>


@endsection
