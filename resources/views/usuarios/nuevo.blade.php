@extends('layout.app')

@section('title')
    Nuevo Usuario
@endsection

@section('cabecera')
    Usuarios
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
    <script src="{{url('/js/usuarios/nuevo.js')}}"></script>
@endsection

@section('contenedor')
    <div class="row">
        <h2>Nuevo Usuario</h2>
    </div>
    <div class="row">
        @foreach($errors->all() as $error)
            <div class="red-text">{{$error}}</div>
        @endforeach
        <form id="form-crear" method="post" action="{{url('/empresas/crear')}}" class="col s12"
              enctype="multipart/form-data">
            {{csrf_field()}}

            <div class="row">

                <div class="input-field col s12">
                    <input id="curp" name="curp" type="text" class="validate" maxlength="18"
                           style="text-transform: uppercase">
                    <label for="curp">CURP</label>
                </div>

                <div class="input-field col s12 ">
                    <input readonly id="nombre" name="nombre" type="text" >
                    <label for="nombre">Nombre</label>
                </div>

                <div class="input-field col s12 ">
                    <input readonly id="apellido_paterno" name="apellido_paterno" type="text">
                    <label for="apellido_paterno">Apellido Paterno</label>
                </div>

                <div class="input-field col s12 ">
                    <input readonly id="apellido_materno" name="apellido_materno" type="text">
                    <label for="apellido_materno">Apellido Materno</label>
                </div>

                <div class="input-field col s12 ">
                    <input id="email" name="email" type="email" class="validate">
                    <label for="email">Correo electrónico</label>
                </div>

                <div class="input-field col s12">
                    <input id="password" name="password" type="password" class="validate">
                    <label for="password">Contraseña</label>
                </div>

                <div class="input-field col s12">
                    <input id="confirmar_password" name="confirmar_password" type="password" class="validate">
                    <label for="confirmar_password">Confirmar contraseña</label>
                </div>

                <div class="input-field col s12 ">
                    <input id="telefono" name="telefono" type="tel" class="validate">
                    <label for="telefono">Teléfono</label>
                </div>

                <div class="input-field col s12">
                    <select required id="rol" name="rol" class="select-wrapper validate">
                        <option value="" selected>Elige una opción</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id }}">{{ $rol->nombre_vista }}</option>
                        @endforeach
                    </select>
                    <label for="rol">Rol</label>
                </div>

                <div class="col s12">
                    <ul class="list-group">
                        @foreach($permisos as $permiso)
                            <li id="{{ $permiso->id }}" class="list-group-item-rol">{{ $permiso->nombre_vista }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="input-field col s12">
                    <select required id="puesto" name="puesto" class="select-wrapper validate">
                        <option value="" selected>Elige una opción</option>
                        @foreach($puestos as $puesto)
                            <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                        @endforeach
                    </select>
                    <label for="puesto">Puesto</label>
                </div>

                <div class="col s4">
                    <ul class="list-group">
                        @foreach($areas as $area)
                            <li id="area_{{ $area->id }}"class="list-group-item-puesto">{{ $area->nombre }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="col s4">
                    <ul class="list-group">
                        @foreach($direcciones as $direccion)
                            <li id="direccion_{{ $direccion->id }}" class="list-group-item-puesto">{{ $direccion->nombre }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="col s4">
                    <ul class="list-group">
                        @foreach($dependencias as $dependencia)
                            <li id="dependencia_{{ $dependencia->id }}" class="list-group-item-puesto">{{ $dependencia->nombre }}</li>
                        @endforeach
                    </ul>
                </div>

                <input class="input-field btn right" style="background: #BF3364;" type="submit" value="Registrar">
            </div>
        </form>
    </div>

<<<<<<< HEAD
=======
    <script>
        $(function () {
            $('#curp').keyup(function () {
                if ($('#curp').val().length === 18) {
                    var curp = $('#curp').val().toLocaleUpperCase();
                    $.ajax({
                        type: "POST",
                        url: 'curp',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {
                            curp: curp
                        },
                        success: function (data) {
                            $('#nombre').val(data.data.nombres).trigger('change');
                            $('#apellido_paterno').val(data.data.PrimerApellido).trigger('change');
                            $('#apellido_materno').val(data.data.SegundoApellido).trigger('change');
                            $('#fecha_nacimiento').val(data.data.fechNac).trigger('change')
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                } else if ($('#curp').val().length < 18) {
                    $('#nombre').val('')
                    $('#apellido_paterno').val('');
                    $('#apellido_materno').val('');
                    $('#fecha_nacimiento').val('');
                }
            });

            $('#rol').change(function () {
                var id_rol = $('#rol').val();

                $.ajax({
                    type: 'POST',
                    url: 'obtenerPermisos',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        id_rol : id_rol
                    },
                    success: function(data) {
                        
                        console.log(data.permisos_rol);

                        $('.list-group-item-rol').removeClass('list-group-item-info');

                        $.each(data.permisos_rol, function(index, value) {
                            $('#' + value.id).addClass('list-group-item-info');
                        });

                    },
                    error: function(data) {
                        console.log(data);
                    }
                });

            })

            $('#puesto').change(function() {
                var id_puesto = $('#puesto').val();

                $.ajax({
                    type: 'POST',
                    url: 'obtenerValoresPuesto',
                    headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        id_puesto : id_puesto
                    },
                    success: function(data) {
                        $('.list-group-item-puesto').removeClass('list-group-item-info');
                        
                        $('#area_'  + data.area.id).addClass('list-group-item-info');
                        $('#direccion_' + data.direccion.id).addClass('list-group-item-info');
                        $('#dependencia_' + data.dependencia.id).addClass('list-group-item-info');

                    },
                    error: function(data) {

                    }
                });
            })
        })
    </script>

>>>>>>> 96f8b3f9eac3ef37c9fc24ab30dbab0101e4729b
@endsection
