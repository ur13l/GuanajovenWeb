@extends('layout.app')

@section('title')
    Historial de Notificaciones
@endsection

@section('cabecera')
    Historial de Notificaciones
@endsection

@section('contenedor')
    <div class="row">
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
@endsection