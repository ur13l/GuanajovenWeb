@extends('layout.app')

@section('title')
    Eventos
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/eventos.js')}}"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>
@endsection

@section('cabecera')
    Eventos
@endsection

@section('contenedor')
    <h2 style="margin-top: -5px; display: inline-block;">Evento "{{ $evento->titulo }}"</h2>
    <div style="margin-top: -5px; display: inline-block; float: right;">
        <div class="titulos-fecha-ini" style="display: inline-block;">
            <h6 style="display: inline-block; font-weight: bold;">Fecha de inicio</h6><br/>
            <h6 style="display: inline-block;">{{ date('d/m/Y H:i:s', strtotime($evento->fecha_inicio)) }}</h6>
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <div class="titulos-fecha-fin" style="display: inline-block;">
            <h6 style="display: inline-block; font-weight: bold;">Fecha de finalización</h6><br/>
            <h6 style="display: inline-block;">{{ date('d/m/Y H:i:s', strtotime($evento->fecha_fin)) }}</h6>
        </div>
    </div>
    <div class="row">
        <h4>Lista de asistentes</h4>
        <table id="tabla-asistentes" class="display highlight" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th data-field="numero">#</th>
                <th data-field="id_guanajoven">I.D. Guanajoven</th>
                <th data-field="nombre">Nombre</th>
                <th data-field="apellido_paterno">Apellido paterno</th>
                <th data-field="curp">CURP</th>
                <th data-field="correo">Correo</th>
                <th data-field="genero">Género</th>
                <th data-field="edad">Edad</th>
            </tr>
            </thead>
            <tbody id="tabla-asistentes">
            @foreach($usuariosAsistentes as $key => $usuario)
                <tr>
                    <td class="numero">{{ $key + 1 }}</td>
                    <td class="id_guanajoven">{{ $usuario->codigoGuanajoven->id_codigo_guanajoven }}</td>
                    <td class="nombre">{{ $usuario->datosUsuario->nombre }}</td>
                    <td class="apellido_paterno">{{ $usuario->datosUsuario->apellido_paterno }}</td>
                    <td class="curp">{{ $usuario->datosUsuario->curp }}</td>
                    <td class="correo">{{ $usuario->email }}</td>
                    <td class="genero">{{ $usuario->datosUsuario->genero->nombre }}</td>
                    <td class="edad">{{ $usuario->edad }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row col-md-12">
        <div class="col-md-6" style="width: 48%; display: inline-block;">
            <canvas id="canvas-asistentes"></canvas>
        </div>
    </div>
    <script>
        var cantidad1 = Number('{{ count($usuariosAsistentes) }}');

        var config = {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'Cantidad',
                    backgroundColor: 'rgb(255, 255, 100)',
                    data: [
                        cantidad1
                    ]
                }]
            },
            options: {
                responsive: true,
                title:{
                    display: true,
                    text:'Usuarios que asistieron'
                },
                scales: {
                    yAxes: [{
                        display: true,
                        ticks: {
                            min: 0,
                            max: cantidad1 + 1,
                            stepSize: 1
                        }
                    }]
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById("canvas-asistentes").getContext("2d");
            window.myBar = new Chart(ctx, config);
        };
    </script>
@endsection
