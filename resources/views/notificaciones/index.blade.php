@extends('layout.app')

@section('title')
    Notificaciones
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{url('/js/notificaciones/index.js')}}"> </script>
@endsection

@section('cabecera')
    Notificaciones
@endsection

@section('contenedor')

    <!--Modal eliminar-->
    <div id="deleteModalNotif" class="modal">
        <form action="{{url('/notificaciones/eliminar')}}" method="post">
            <div class="modal-content">
                <h4>Confirmar</h4>
                <p id="delete-message">¿Desea eliminar la(s) notificación(es) seleccionada(s)?</p>
                <input type="hidden" name="id-eliminar" id="id-eliminar">
                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
                <input type="submit" href="#" class="waves-effect waves-green btn-flat"  value="Sí" id="yesBtn"/>
            </div>
        </form>
    </div>



    <!-- Cuerpo del index -->
    <div class="row">

        @if(Session::has('messages'))
            <script>
                $(function() {
                    Materialize.toast('{{Session::get('messages')}}', 4000, 'green');
                })
            </script>
        @endif

        <form action="/notificaciones/enviar" id="form-enviar" method="post">
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
            <div class="advanced">
                <div class="row">
                    <div class="col s12 m6">
                    <h6 class="col s12 "> Por género </h6>
                    <div class="input-field col s12">
                        <input type="checkbox" id="chk_hombre" name="chk_hombre" value="hombre" class="filled-in checkbox-accent-color" checked>
                        <label for="chk_hombre">Hombres</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="checkbox" id="chk_mujer" name="chk_mujer" value="mujer" class="filled-in checkbox-accent-color" checked>
                        <label for="chk_mujer">Mujeres</label>
                    </div>
                    </div>
                <div class="col s12 m6">
                    <h6 class="col s12 m6"> Sistema operativo </h6>
                    <div class="input-field col s12">
                        <input type="checkbox" id="chk_android" name="chk_android" value="android" class="filled-in checkbox-accent-color" checked>
                        <label for="chk_android">Android</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="checkbox" id="chk_ios" name="chk_ios" value="ios" class="filled-in checkbox-accent-color" checked>
                        <label for="chk_ios">iOS</label>
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

                <div class="row">
                    <h6 class="col s12"> Por región </h6>
                    <div class="input-field col s12">
                        <select required id="sl_region" name="sl_region[]" class="validate primary-color-text" multiple>q
                            @foreach($regiones as $region)
                                <option value="{{$region->id_region}}" selected>{{$region->nombre}}</option>
                            @endforeach
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

            </div>
            <div class="row right">
                <a class="waves-effect waves-light btn accent-color" id="show-advanced" ><i class="material-icons left">settings</i>Configurar Destinatarios</a>
                <button type="submit" class="waves-effect waves-light btn accent-color" id="enviar"><i class="material-icons left">send</i>Enviar</button>

            </div>
        </form>
    </div>

    <div class="divider"></div>
    <!-- Lógica para mostrar notificaciones -->
    <div class="rowsection" id="table">
        <h5 class="col s12">Notificaciones enviadas</h5>

        @if(count($notificaciones) == 0)
            <div class="section">No hay notificaciones disponibles</div>
        @else


        <table class="highlight">
            <thead>
            <tr>
                <th data-field="check">
                    <input type="checkbox" id="chk-todos" class="filled-in checkbox-accent-color" >
                    <label for="chk-todos"></label>
                </th>
                <th data-field="titulo">Título</th>
                <th data-field="mensaje">Mensaje</th>
                <th data-field="fecha">Fecha</th>
                <th data-field="eliminar">Eliminar</th>

            </tr>
            </thead>
            <tbody id="tabla-notificaciones">
                    @foreach($notificaciones as $notificacion)
                        <tr>
                            <td>
                                <input type="checkbox" id="chk{{$notificacion->id_notificacion}}" value="{{$notificacion->id_notificacion}}" class="check-delete filled-in checkbox-accent-color" >
                                <label for="chk{{$notificacion->id_notificacion}}"></label>
                            </td>
                            <td>{{$notificacion->titulo}}</td>
                            <td>{{$notificacion->mensaje}}</td>
                            <td>{{$notificacion->fecha_emision->format('d/m/Y h:i:s')}}</td>
                            <td class="center-align"><a data-id="{{$notificacion->id_notificacion}}" class="delete-notif" style="cursor:pointer;"><i class="material-icons grey-text">delete</i></a></td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
        @endif
        <ul class="pagination">
            {{$notificaciones->links()}}
        </ul>
    </div>
    </div>

    <div class="fixed-action-btn" id="delete-selection" style="display:none; bottom: 10px; right: 100px;">
        <a class="btn-floating btn-large waves-effect waves-light accent-color btn" >
            <i class="material-icons">delete</i>
        </a>
    </div>


@endsection
