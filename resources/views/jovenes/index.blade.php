@extends('layout.app')

@section('title')
    Jóvenes
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
    <script type="text/javascript">
        var urlBorrar = "{{url('/jovenes/borrar')}}"
    </script>
    <script type="text/javascript" src="{{url('/js/joven/borrar.js')}}"></script>
@endsection

@section('cabecera')
    Jóvenes
@endsection

@section('contenedor')

    <!-- Cuerpo del index -->
    <div class="row">
        <div class="col s1">
            <div class="fixed-action-btn">
            <a class="btn-floating btn-large waves-effect waves-light" style="background: #BF3364" href="{{url('jovenes/nuevo')}}"><i class="material-icons">add</i></a>
            </div>      
        </div>
        <div class="col s4 offset-s8">
            <div class="left-align">
                <div class="input-field">
                    <input id="search" type="search" required>
                    <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                    <i class="material-icons">close</i>
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
                    <th data-field="codigo">Código</th>
                    <th data-field="nombre">Nombre</th>
                    <th data-field="apellido_paterno">Apellido Paterno</th>
                    <th data-field="apelldo_materno">Apellido Materno</th>
                    <th data-field="curp">CURP</th>
                    <th data-field="email">Correo electrónico</th>
                    <th data-field="municipio">Municipio</th>
                    <th data-field="id_genero">Género</th>
                    <th data-field="fecha_registro">Fecha de registro</th>
                    <th data-field="edad">Edad</th>
                    <th data-field="editar">Editar</th>
                    <th data-field="eliminar">Eliminar</th>
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
                                <td>{{isset($user->codigoGuanajoven) ? $user->codigoGuanajoven->email: ""}}</td>
                                <td>{{isset($user->datosUsuario) ? $user->datosUsuario->id_municipio : ""}}</td>
                                <td>{{isset($user->datosUsuario) ? $user->datosUsuario->id_genero: ""}}</td>
                                <td>{{$user->created_at->format('d/m/Y h:i:s')}}</td>
                                <td>{{isset($user->datosUsuario) ? $user->datosUsuario->fecha_nacimiento->diffInYears(\Carbon\Carbon::now()) : ""}}</td>
                                <td class="center-align"><i class="material-icons grey-text" data-user-id="{{$user->id}}">mode_edit</i></td>
                                <td class="center-align"><i class="material-icons grey-text borrar" data-user-id="{{$user->id}}">delete</i></td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
            @endif
            <ul class="pagination">
        <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
        <li class="active"><a href="#!">1</a></li>
        <li class="waves-effect"><a href="#!">2</a></li>
        <li class="waves-effect"><a href="#!">3</a></li>
        <li class="waves-effect"><a href="#!">4</a></li>
        <li class="waves-effect"><a href="#!">5</a></li>
        <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>
        </div>
</div>

    <div id="modal-borrar" title="¿Borrar usuario?">
        <p>¿Desea borrar este elemento?</p>
        <form id="form-borrar" action="{{url('/jovenes/borrar')}}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id_usuario" value="" id="id_usuario">
        </form>
    </div>    
@endsection


