<tr class="item-evento">
    <input type="hidden" class="id" value="{{ $evento->id_evento }}">
    <td class="check">
        <input type="checkbox" id="chk{{ $evento->id_evento }}" class="filled-in chk checkbox-accent-color" />
        <label for="chk{{ $evento->id_evento }}"></label>
    </td>
    <td class='titulo'>{{ $evento->titulo }}</td>
    <td class='descripcion'>{{ $evento->descripcion }}</td>
    <td class='fInicio'>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:m:s', $evento->fecha_inicio)->format('d/m/Y H:m:s') }}</td>
    <td class='fFin'>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:m:s', $evento->fecha_fin)->format('d/m/Y H:m:s') }}</td>
    <input class='tipo' type='hidden' value='{{ $evento->tipo }}'>
    <td class='edit' style='cursor:pointer'>
        <i class='material-icons'>edit</i>
    </td>
    <td class='delete' style='cursor:pointer'>
        <i class='material-icons'>delete</i>
    </td>
</tr>
