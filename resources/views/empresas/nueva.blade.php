@extends('layout.app')

@section('title')
    Nueva Empresa
@endsection

@section('cabecera')
    Empresas
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
    <script src="{{url('/js/empresas/nueva.js')}}"></script>
@endsection

@section('contenedor')
    <div class="row">
        <h2>Nueva Empresa</h2>
    </div>
    <div class="row">
        @foreach($errors->all() as $error)
            <div class="red-text">{{$error}}</div>
        @endforeach
        <form id="form-crear" method="post" action="{{url('/empresas/crear')}}" class="col s12" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">
                <div class="input-field col s12">
                    <input id="empresa" name="empresa" type="text" class="validate">
                    <label for="empresa">Empresa</label>
                </div>
                <div class="input-field col s12 ">
                    <input id="nombre_comercial" name="nombre_comercial" type="text" class="validate">
                    <label for="nombre_comercial">Nombre Comercial</label>
                </div>
                <div class="input-field col s12 ">
                    <input id="razon_social" name="razon_social" type="text" class="validate">
                    <label for="razon_social">Razón social</label>
                </div>
                <div class="input-field col s12 ">
                    <input id="convenio" name="convenio" type="text" class="validate">
                    <label for="convenio">Convenio</label>
                </div>
                <div class="input-field col s12 m6">
                        <select required id="estatus" name="estatus" class="select-wrapper validate">
                                <option value=""  selected>Elige una opción</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                        </select>
                        <label for="estatus">Estatus</label>
                </div>
                <div class="input-field col s12 m6">
                    <select required id="prioridad"  name="prioridad" class="select-wrapper validate">
                        <option value=""  selected>Elige una opción</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                    </select>
                    <label for="prioridad">Prioridad</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="url_empresa" name="url_empresa" type="text" class="validate">
                    <label for="url_empresa">URL de empresa</label>
                </div>
                <div class="file-field input-field col s12 l6">
                    <div class="btn" style="background: #BF3364;">
                        <span>Imagen</span>
                        <input type="file" name="logo" >
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Subir imagen">
                    </div>
                </div>

                    <input class="input-field btn right" style="background: #BF3364;" type="submit" value="Registrar">
            </div>


        </form>
    </div>

@endsection
