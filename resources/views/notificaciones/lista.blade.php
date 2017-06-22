<h5 class="col s12">Notificaciones enviadas</h5>

@if(count($notificaciones) == 0)
    <div class="section">No hay notificaciones disponibles</div>
@else


    <table class="highlight">
        <thead>
        <tr>
            <th data-field="check">
                <input type="checkbox" id="chk-todos" class="check-delete filled-in checkbox-accent-color" >
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
