@extends('layout.app')

@section('title')
    Jóvenes
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{url('/js/joven/index.js')}}"></script>
@endsection

@section('cabecera')
    Jóvenes
@endsection

@section('contenedor')

    <!-- Cuerpo del index -->
    <div class="row">
        <!--<div class="col s1">
            <div class="fixed-action-btn">
                <a class="btn-floating btn-large waves-effect waves-light" style="background: #BF3364" href="{{url('jovenes/nuevo')}}"><i class="material-icons">add</i></a>
            </div>      
        </div>-->
        <div class="col s4 offset-s8">
            <div class="left-align">
                <div class="input-field">
                   <i class="material-icons prefix">search</i>
                   <input id="icon_search" type="text" class="validate">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Lógica para mostrar tabla -->
        <div class="rowsection" id="table">
            @if(count($usuarios) == 0)
            <div class="section">No hay datos</div>
            @else
            <table class="highlight">
                <thead>
                    <tr>
                        <th class="header" data-field="codigo_guanajoven.id"><i class="material-icons grey-text" style="cursor">arrow_drop_up</i>Código</th>
                        <th class="header" data-field="datos_usuario.nombre">Nombre</th>
                        <th class="header" data-field="datos_usuario.apellido_paterno">Apellido Paterno</th>
                        <th class="header" data-field="datos_usuario.apellido_materno">Apellido Materno</th>
                        <th class="header" data-field="datos_usuario.curp">CURP</th>
                        <th class="header" data-field="usuario.email">Correo electrónico</th>
                        <th class="header" data-field="municipio.nombre">Municipio</th>
                        <th class="header" data-field="genero.nombre">Género</th>
                        <th class="header" data-field="datos_usuario.edad">Edad</th>
                        <th class="header" data-field="usuario.created_at">Fecha de registro</th>
                        <!--<th data-field="editar">Editar</th>
                        <th data-field="eliminar">Eliminar</th>-->
                    </tr>
                </thead>
                <tbody id="tabla-usuarios">
                        @foreach($usuarios as $user)
                            <tr>
                                <td>{{isset($user->codigoGuanajoven) ? $user->codigoGuanajoven->id_codigo_guanajoven : ""}}</td>
                                <td>{{isset($user->datosUsuario) ? $user->datosUsuario->nombre : ""}}</td>
                                <td>{{isset($user->datosUsuario) ? $user->datosUsuario->apellido_paterno : ""}}</td>
                                <td>{{isset($user->datosUsuario) ? $user->datosUsuario->apellido_materno : ""}}</td>
                                <td>{{isset($user->datosUsuario) ? $user->datosUsuario->curp : ""}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{isset($user->datosUsuario) ? $user->datosUsuario->municipio->nombre : ""}}</td>
                                <td>{{isset($user->datosUsuario) ? $user->datosUsuario->genero->nombre: ""}}</td>
                                <td>{{isset($user->datosUsuario) ? $user->datosUsuario->fecha_nacimiento->diffInYears(\Carbon\Carbon::now()) : ""}}</td>
                                <td>{{$user->created_at->format('d/m/Y')}}</td>
                                <!--<td class="center-align"><i class="material-icons grey-text" style="cursor: pointer" data-user-id="{{$user->id}}">mode_edit</i></td>
                                <td class="center-align"><i class="material-icons grey-text borrar" style="cursor: pointer" data-user-id="{{$user->id}}">delete</i></td>-->
                            </tr>
                        @endforeach
                </tbody>
            </table>
            @endif
            <ul class="pagination">
                {{$usuarios->links()}}
            </ul>
        </div>
    </div>
    <!--Modal para eliminar joven-->
    <!--
    <div id="modal-borrar" class="modal">
        <form action="{{url('/jovenes/borrar')}}" method="post">
            <div class="modal-content">
                <h4>Confirmar</h4>
                <p id="delete-message">¿Desea eliminar este elemento?</p>
                <input type="hidden" name="id_usuario" id="id_usuario">
                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
                <input type="submit" href="#" class="waves-effect waves-green btn-flat"  value="Sí" id="yesBtn"/>
            </div>
        </form>
    </div>-->
@endsection


