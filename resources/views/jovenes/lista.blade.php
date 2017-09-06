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