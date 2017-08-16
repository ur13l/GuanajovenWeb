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
    <div class="row">
        <h2>"{{ $titulo }}"</h2>
    </div>
    <div class="row col-md-12">
        <div class="col-md-6" style="width: 48%; display: inline-block;">
            <canvas id="canvas-asistentes"></canvas>
        </div>
        <div class="col-md-6" style="width: 48%; display: inline-block;">
            <canvas id="canvas-interesados"></canvas>
        </div>
    </div>
    <div class="row">
        <h4>Lista de asistentes</h4>
        <table class="highlight">
            <thead>
                <tr>
                    <th data-field="curp">CURP</th>
                    <th data-field="nombre">Nombre</th>
                    <th data-field="apellido_paterno">Apellido paterno</th>
                    <th data-field="apellido_materno">Apellido materno</th>
                    <th data-field="correo">Correo</th>
                </tr>
            </thead>
            <tbody id="tabla-asistentes">
                @foreach($usuariosAsistentes as $usuario)
                    <tr>
                        <td class="curp">{{ $usuario->datosUsuario->curp }}</td>
                        <td class="nombre">{{ $usuario->datosUsuario->nombre }}</td>
                        <td class="apellido_paterno">{{ $usuario->datosUsuario->apellido_paterno }}</td>
                        <td class="apellido_materno">{{ $usuario->datosUsuario->apellido_materno }}</td>
                        <td class="correo">{{ $usuario->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        var cantidad1 = Number('{{ count($usuariosAsistentes) }}');
        var cantidad2 = Number('{{ count($usuariosInteresados) }}');

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

        var config2 = {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'Cantidad',
                    backgroundColor: 'rgb(100, 200, 100)',
                    data: [
                        cantidad2
                    ]
                }]
            },
            options: {
                responsive: true,
                title:{
                    display: true,
                    text:'Usuarios interesados'
                },
                scales: {
                    yAxes: [{
                        display: true,
                        ticks: {
                            min: 0,
                            max: cantidad2 + 1,
                            stepSize: 1
                        }
                    }]
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById("canvas-asistentes").getContext("2d");
            window.myBar = new Chart(ctx, config);
            var ctx = document.getElementById("canvas-interesados").getContext("2d");
            window.myBar = new Chart(ctx, config2);
        };
    </script>
@endsection
