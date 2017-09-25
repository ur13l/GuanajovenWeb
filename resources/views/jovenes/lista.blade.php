<div class="row">
    <!-- Lógica para mostrar tabla -->
    <div class="rowsection" id="table">
        @if(count($usuarios) == 0)
        <div class="section">No hay datos</div>
        @else
        <table class="highlight">
            <thead>
                <tr>
                    <th class="header" data-field="codigo_guanajoven.id">Código</th>
                    <th class="header" data-field="datos_usuario.nombre">Nombre</th>
                    <th class="header" data-field="datos_usuario.apellido_paterno">Apellido Paterno</th>
                    <th class="header" data-field="datos_usuario.apelldo_materno">Apellido Materno</th>
                    <th class="header" data-field="datos_usuario.curp">CURP</th>
                    <th class="header" data-field="usuario.email">Correo electrónico</th>
                    <th class="header" data-field="municipio.nombre">Municipio</th>
                    <th class="header" data-field="genero.nombre">Género</th>
                    <th class="header" data-field="datos_usuario.edad">Edad</th>
                    <th class="header" data-field="usuario.created_at">Fecha de registro</th>
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
                        <td>{{$user->email}}</td>
                        <td>{{isset($user->datosUsuario) ? $user->datosUsuario->municipio->nombre : ""}}</td>
                        <td>{{isset($user->datosUsuario) ? $user->datosUsuario->genero->nombre: ""}}</td>
                        <td>{{$user->created_at->format('d/m/Y h:i:s')}}</td>
                        <td>{{isset($user->datosUsuario) ? $user->datosUsuario->fecha_nacimiento->diffInYears(\Carbon\Carbon::now()) : ""}}</td>
                        <td class="center-align"><i class="material-icons grey-text" style="cursor: pointer" data-user-id="{{$user->id}}">mode_edit</i></td>
                        <td class="center-align"><i class="material-icons grey-text borrar" style="cursor: pointer" data-user-id="{{$user->id}}">delete</i></td>
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