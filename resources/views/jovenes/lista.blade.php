<div class="row">
    <!-- Lógica para mostrar tabla -->
    <div class="rowsection" id="table">
        @if(count($usuarios) == 0)
        <div class="section">No hay datos</div>
        @else
        <table class="highlight">
            <thead>
                <tr>
                    <th class="header" data-field="codigo_guanajoven.id_codigo_guanajoven" style="width: 100px; cursor: pointer">Código</th>
                    <th class="header" data-field="datos_usuario.nombre" style="width: 150px; cursor: pointer">Nombre</th>
                    <th class="header" data-field="datos_usuario.apellido_paterno" style="width: 100px; cursor: pointer">Apellido Paterno</th>
                    <th class="header" data-field="datos_usuario.apellido_materno" style="width: 100px; cursor: pointer">Apellido Materno</th>
                    <th class="header" data-field="datos_usuario.curp" style="width: 100px; cursor: pointer">CURP</th>
                    <th class="header" data-field="usuario.email" style="width: 100px; cursor: pointer">Correo electrónico</th>
                    <th class="header" data-field="municipio.nombre" style="width: 100px; cursor: pointer">Municipio</th>
                    <th class="header" data-field="genero.nombre"style="width: 100px; cursor: pointer">Género</th>
                    <th class="header" data-field="datos_usuario.fecha_nacimiento" style="width: 100px; cursor: pointer">Edad</th>
                    <th class="header" data-field="usuario.created_at" style="width: 100px; cursor: pointer">Fecha de registro</th>
                    <!--<th data-field="editar">Editar</th>
                    <th data-field="eliminar">Eliminar</th>-->
                </tr>
            </thead>
            <tbody id="tabla-usuarios">
                    @foreach($usuarios as $user)
                        <tr>
                            <td style="width: 100px" >{{isset($user->codigoGuanajoven) ? $user->codigoGuanajoven->id_codigo_guanajoven : ""}}</td>
                            <td style="width: 150px">{{isset($user->datosUsuario) ? $user->datosUsuario->nombre : ""}}</td>
                            <td style="width: 100px">{{isset($user->datosUsuario) ? $user->datosUsuario->apellido_paterno : ""}}</td>
                            <td style="width: 100px">{{isset($user->datosUsuario) ? $user->datosUsuario->apellido_materno : ""}}</td>
                            <td style="width: 100px">{{isset($user->datosUsuario) ? $user->datosUsuario->curp : ""}}</td>
                            <td style="width: 100px">{{$user->email}}</td>
                            <td style="width: 100px">{{isset($user->datosUsuario) ? $user->datosUsuario->municipio->nombre : ""}}</td>
                            <td style="width: 100px">{{isset($user->datosUsuario) ? $user->datosUsuario->genero->nombre: ""}}</td>
                            <td style="width: 100px">{{isset($user->datosUsuario) ? $user->datosUsuario->fecha_nacimiento->diffInYears(\Carbon\Carbon::now()) : ""}}</td>
                            <td style="width: 100px">{{$user->created_at->format('d/m/Y')}}</td>
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