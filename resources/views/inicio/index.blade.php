@extends('layout.app')

@section('title')
    Inicio
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{url('/js/joven/index.js')}}"></script>
@endsection

@section('cabecera')
    Inicio
@endsection

@section('contenedor')

    <!-- Cuerpo del index -->


    <div class="row">
        <!-- Lógica para mostrar tabla -->
        <div class="rowsection" id="table">
            <center><h1>¡Bienvenido a Guanajoven!</h1></center>
            <center><img src="{{ url('img/logo_guanajoven.png') }}"/></center>
        </div>
    </div>
    <!--Modal para eliminar joven-->
    <div id="modal-borrar" class="modal">
        <form action="{{url('/jovenes/borrar')}}" method="post">
            <div class="modal-content">
                <h4>Confirmar</h4>
                <p id="delete-message">¿Desea eliminar este elemento?</p>
                <input type="hidden" name="id_usuario" id="id_usuario">
                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
                <input type="submit" href="#" class="waves-effect waves-green btn-flat"  value="Sí" id="yesBtn"/>
            </div>
        </form>
    </div>
@endsection


