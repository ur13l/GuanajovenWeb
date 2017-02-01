<?php
session_start();
if (isset($_SESSION['usuario_correo'])) {
    $correo = $_SESSION['usuario_correo'];
} else {
    header("Locationheader:../../index.html");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{url('materialize/css/materialize.min.css')}}">
        <link rel="stylesheet" href="{{url('css/style.css')}}">
        <link rel="stylesheet" href="{{url('/css/lolliclock.css')}}">
        <link rel="stylesheet" href="{{url('/css/toastr.min.css')}}">
        <link rel="stylesheet" href="{{url('/css/nouislider.css')}}">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script type="text/javascript" src="{{url('js/jquery-1.12.3.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/lolliclock.js')}}"></script>
        <script type="text/javascript" src="{{url('materialize/js/materialize.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/ion.rangeSlider.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/moment.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/toastr.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/jquery.twbsPagination.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/usuarios.js')}}"> </script>
        <script type="text/javascript" src="{{url('/js/nouislider.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/jquery.twbsPagination.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/notificaciones.js')}}"> </script>
        <script type="text/javascript" src="{{url('/js/eventos.js')}}"> </script>
        <script type="text/javascript" src="{{url('/js/video.js')}}"> </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".button-collapse").sideNav();
                $('.modal-trigger').leanModal();
                $('.datepicker').pickadate({
                    selectMonths: true,
                    selectYears: 15
                });
            });
        </script>
    </head>
    <body style="background: #f1f1f1">
        <!--Barra de navegación-->
        <nav>
            <div class="nav-wrapper blue-code">
                <a href="#" class="brand-logo" style="padding-left: 2.5%;">@yield('cabecera')</a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>

                <ul class="right hide-on-med-and-down">
                    <li><a href="{{url('reportes')}}">Reportes</a></li>
                    <li><a href="{{url('usuarios')}}">Usuarios</a></li>
                    <li><a href="{{url('publicidad')}}">Publicidad</a></li>
                    <li><a href="{{url('convocatorias')}}">Convocatorias</a></li>
                    <li><a href="{{url('notificaciones')}}">Notificaciones</a></li>
                    <li><a href="{{url('historial')}}">Historial Notificaciones</a></li>
                    <li><a href="{{url('eventos')}}">Eventos</a></li>
                    <li><a href="{{url('video')}}">Video</a></li>
                    <li><a href="{{url('logout.php')}}">Cerrar sesión</a></li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    <li><a href="{{url('reportes')}}">Reportes</a></li>
                    <li><a href="{{url('usuarios')}}">Usuarios</a></li>
                    <li><a href="{{url('publicidad')}}">Publicidad</a></li>
                    <li><a href="{{url('convocatorias')}}">Convocatorias</a></li>
                    <li><a href="{{url('notificaciones')}}">Notificaciones</a></li>
                    <li><a href="{{url('historial')}}">Historial Notificaciones</a></li>
                    <li><a href="{{url('eventos')}}">Eventos</a></li>
                    <li><a href="{{url('video')}}">Video</a></li>
                    <li><a href="{{url('logout.php')}}">Cerrar sesión</a></li>
                </ul>
            </div>
        </nav>
        <div class="container" style="background:white;  padding:30px; margin-top:50px;">
            <div class="row">
                <img src="{{url('img/logo_guanajoven.png')}}" class="col s9 m6 l3 offset-s2 offset-m3 offset-l4">
            </div>
            @yield('contenedor')
        </div>
    </body>
</html>