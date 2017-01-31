<?php
session_start();
if (isset($_SESSION['usuario_correo'])) {
    $correo = $_SESSION['usuario_correo'];
} else {
    header('Location: ../../index.html');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="materialize/css/materialize.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script type="text/javascript" src="js/jquery-1.12.3.js"></script>
        <script type="text/javascript" src="materialize/js/materialize.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".button-collapse").sideNav();
                $('.modal-trigger').leanModal();
            });
        </script>
    </head>
    <body style="background: #f1f1f1">
        <!--Barra de navegación-->
        <nav>
            <div class="nav-wrapper blue-code">
                <a href="#" class="brand-logo" style="padding-left: 2.5%;">Guanajoven</a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>

                <ul class="right hide-on-med-and-down">
                    <li><a href="reportes.php">Reportes</a></li>
                    <li><a href="usuarios.php">Usuarios</a></li>
                    <li><a href="{{url('publicidad')}}">Publicidad</a></li>
                    <li><a href="{{url('convocatorias')}}">Convocatorias</a></li>
                    <li><a href="notificaciones.php">Notificaciones</a></li>
                    <li><a href="historial.php">Historial Notificaciones</a></li>
                    <li><a href="eventos.php">Eventos</a></li>
                    <li><a href="video.php">Video</a></li>
                    <li><a href="../../logout.php">Cerrar sesión</a></li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    <li><a href="reportes.php">Reportes</a></li>
                    <li><a href="usuarios.php">Usuarios</a></li>
                    <li><a href="{{url('publicidad')}}">Publicidad</a></li>
                    <li><a href="{{url('convocatorias')}}">Convocatorias</a></li>
                    <li><a href="notificaciones.php">Notificaciones</a></li>
                    <li><a href="historial.php">Historial Notificaciones</a></li>
                    <li><a href="eventos.php">Eventos</a></li>
                    <li><a href="video.php">Video</a></li>
                    <li><a href="../../logout.php">Cerrar sesión</a></li>
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