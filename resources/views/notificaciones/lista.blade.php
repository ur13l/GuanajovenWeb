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
    @foreach($notificaciones as $notificacion)
        <tr>
            <td>
                <input type="checkbox" id="chk{{$notificacion->id_notificacion}}" value="{{$notificacion->id_notificacion}}" class="check-delete filled-in checkbox-accent-color" >
                <label for="chk{{$notificacion->id_notificacion}}"></label>
            </td>
            <td>{{$notificacion->titulo}}</td>
            <td>{{$notificacion->mensaje}}</td>
            <td>{{$notificacion->fecha_emision->format('d/m/Y h:i:s')}}</td>
            <td><a data-id="{{$notificacion->id_notificacion}}" class="delete-notif" style="cursor:pointer;"><i class="material-icons grey-text">delete</i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>

<ul class="pagination">
    {{$notificaciones->links()}}
</ul>
