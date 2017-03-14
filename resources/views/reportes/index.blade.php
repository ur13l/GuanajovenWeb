@extends('layout.app')

@section('title')
    Reportes
@endsection

@section('cabecera')
    Reportes
@endsection

@section('contenedor')
    <div class="row">
        <ul>
            <li>
                <form class="" action="{{url('/web/controller/reportes.php')}}" method="post">
                    <div class="row">
                        <h5 class="col s9" style="display:inline">Reporte de usuarios global</h5>
                        <input type="submit" name="export_excel" class="waves-effect waves-light rose_code btn col s3" style="background: #BF3364;" value="Descargar Reporte">
                    </div>
                </form>
            </li>
        </ul>
    </div>
@endsection