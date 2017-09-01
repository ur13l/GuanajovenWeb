@extends('layout.app')

@section('title')
    Eventos
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/eventos.js')}}"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>
    <script>
        $(function() {
            Chart.plugins.register({
                afterDatasetsDraw: function(chart, easing) {
                    // To only draw at the end of animation, check for easing === 1
                    var ctx = chart.ctx;
                    chart.data.datasets.forEach(function (dataset, i) {
                        var meta = chart.getDatasetMeta(i);
                        if (!meta.hidden) {
                            meta.data.forEach(function(element, index) {
                                // Draw the text in black, with the specified font
                                ctx.fillStyle = 'rgb(0, 0, 0)';
                                var fontSize = 16;
                                var fontStyle = 'normal';
                                var fontFamily = 'Helvetica Neue';
                                ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
                                // Just naively convert to string for now
                                var dataString = dataset.data[index].toString();
                                // Make sure alignment settings are correct
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                var padding = 5;
                                var position = element.tooltipPosition();
                                ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection

@section('cabecera')
    Eventos
@endsection

@section('contenedor')
    <div class="row">
        <button class="waves-effect waves-light btn rose-code" id="exportar" style="background: #BF3364; float: right; display: block;">Exportar</button>
    </div>
    <div style="width: 70%; display: inline-block;">
        <h4 style="margin-top: -30px; display: inline-block;">Evento "{{ $evento->titulo }}"</h4>
    </div>
    <div style="margin-top: -5px; width: 30%; display: inline-block; float: right;">
        <div class="titulos-fecha-ini" style="display: inline-block;">
            <h6 style="display: inline-block; font-weight: bold;">Fecha de inicio</h6><br/>
            <h6 style="display: inline-block;">{{ date('d/m/Y', strtotime($evento->fecha_inicio)) }}</h6>
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <div class="titulos-fecha-fin" style="display: inline-block;">
            <h6 style="display: inline-block; font-weight: bold;">Fecha de finalización</h6><br/>
            <h6 style="display: inline-block;">{{ date('d/m/Y', strtotime($evento->fecha_fin)) }}</h6>
        </div>
    </div>
    <div class="row">
        <h4>Lista de asistentes</h4>
        <table id="tabla-asistentes" class="display highlight" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th data-field="numero">#</th>
                <th data-field="id_guanajoven">ID Guanajoven</th>
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
    <div class="row">
        <h4>Dashboard</h4>
        <div class="row">
            <div class="col s5 offset-s1" style="display: inline-block;">
                <canvas id="canvas-asistentes"></canvas>
            </div>
            <div class="col s5 offset-s1" style="width: 22%; display: inline-block;">
                <canvas id="canvas-genero"></canvas>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col s5 offset-s2" style="width: 22%; display: inline-block;">
                <canvas id="canvas-edad"></canvas>
            </div>
            <div class="col s5 offset-s1" style="display: inline-block;">
                <canvas id="canvas-municipio"></canvas>
            </div>
        </div>
    </div>

    <!-- Script para las funciones de la tabla -->
    <script>
        $(document).ready(function() {
            $("#exportar").click(function(e) {
                e.preventDefault();

                //getting data from our table
                var data_type = 'data:application/vnd.ms-excel';
                var table_div = document.getElementById('tabla-asistentes');
                var table_html = table_div.outerHTML.replace(/ /g, '%20');

                var a = document.createElement('a');
                a.href = data_type + ', ' + table_html;
                a.download = 'Asistentes_{{ $evento->titulo }}.xls';
                a.click();
            });
        });

        $(document).ready(function() {
            $('#tabla-asistentes').DataTable({
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ usuarios",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando usuarios del _START_ al _END_ de un total de _TOTAL_ usuarios",
                    "sInfoEmpty":      "Mostrando usuarios del 0 al 0 de un total de 0 usuarios",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ usuarios)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
            $("select").val('10');
            $('select').addClass("browser-default");
            $('select').material_select();
        });
    </script>

    <!-- Script para las gráficas -->
    <script>
        //Asistentes
        var cantidad1 = Number('{{ count($usuariosAsistentes) }}');
        var colores = [
            'rgb(33, 150, 243)',
            'rgb(244, 67, 54)',
            'rgb(76, 175, 80)'
        ];

        var config = {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'Cantidad',
                    backgroundColor: colores,
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

        //Género
        var masculino = 0;
        var femenino = 0;

        @foreach($usuariosAsistentes as $key => $usuario)
            @if($usuario->datosUsuario->genero->nombre == 'Masculino')
                masculino += 1;
            @else
                femenino += 1;
            @endif
        @endforeach

        var config2 = {
            type: 'pie',
            data: {
                datasets: [{
                    label: 'Género',
                    backgroundColor: colores,
                    data: [
                        masculino,
                        femenino
                    ]
                }],
                labels: [
                    'Masculino',
                    'Femenino'
                ]
            },
            options: {
                responsive: true,
                title:{
                    display: true,
                    text:'Género'
                }
            }
        };

        //Edad
        var edades = [];

        @foreach($usuariosAsistentes as $key => $usuario)
            if (edades.length == 0) {
                edades.push({
                    'edad': '{{ $usuario->edad }}',
                    'cantidad': 1
                });
            } else {
                var cambio = false;

                $.each(edades, function(index, edad) {
                    if (edad.edad == '{{ $usuario->edad }}') {
                        edad.cantidad++;
                        cambio = true;
                    }
                });

                if (!cambio) {
                    edades.push({
                        'edad': '{{ $usuario->edad }}',
                        'cantidad': 1
                    });
                }
            }
        @endforeach

        var conjuntoEdades = [];
        var cantidadEdades = [];
        $.each(edades, function(i, edad) {
            conjuntoEdades.push(edad.edad);
            cantidadEdades.push(edad.cantidad);
        });

        var config3 = {
            type: 'pie',
            data: {
                datasets: [{
                    label: 'Edad',
                    backgroundColor: colores,
                    data: cantidadEdades
                }],
                labels: conjuntoEdades
            },
            options: {
                responsive: true,
                title:{
                    display: true,
                    text: 'Edad'
                }
            }
        };

        //Municipio
        var municipios = [];

        @foreach($usuariosAsistentes as $key => $usuario)
            if (municipios.length == 0) {
                municipios.push({
                    'municipio': '{{ $usuario->datosUsuario->municipio->nombre }}',
                    'cantidad': 1
                });
            } else {
                var cambio = false;

                $.each(municipios, function(index, municipio) {
                    if (municipio.municipio == '{{ $usuario->datosUsuario->municipio->nombre }}') {
                        municipio.cantidad++;
                        cambio = true;
                    }
                });

                if (!cambio) {
                    municipios.push({
                        'municipio': '{{ $usuario->datosUsuario->municipio->nombre }}',
                        'cantidad': 1
                    });
                }
            }
        @endforeach

        var conjuntoMunicipios = [];
        var cantidadMunicipios = [];
        var maximo = 0;
        $.each(municipios, function(i, municipio) {
            conjuntoMunicipios.push(municipio.municipio);
            cantidadMunicipios.push(municipio.cantidad);
            if (municipio.cantidad > maximo) maximo = municipio.cantidad;
        });

        var config4 = {
            type: 'bar',
            data: {
                datasets: [{
                    label: 'Cantidad',
                    backgroundColor: colores,
                    data: cantidadMunicipios
                }],
                labels: conjuntoMunicipios
            },
            options: {
                responsive: true,
                title:{
                    display: true,
                    text: 'Municipio'
                },
                scales: {
                    yAxes: [{
                        display: true,
                        ticks: {
                            min: 0,
                            max: maximo + 1,
                            stepSize: 1
                        }
                    }]
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById("canvas-asistentes").getContext("2d");
            window.myBar = new Chart(ctx, config);
            var ctx2 = document.getElementById("canvas-genero").getContext("2d");
            window.myPie = new Chart(ctx2, config2);
            var ctx3 = document.getElementById("canvas-edad").getContext("2d");
            window.myPie = new Chart(ctx3, config3);
            var ctx4 = document.getElementById("canvas-municipio").getContext("2d");
            window.myBar = new Chart(ctx4, config4);
        };
    </script>
@endsection
