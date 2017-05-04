<!--
Autor: Felipe Uriel Infante Martínez
Script que devuelve el template del encabezado mostrado en la interfaz web.
Fecha: 01/05/16
-->

<?php
echo '<nav>
  <div class="nav-wrapper primary-color">
    <a href="#" class="brand-logo" style="padding-left: 2.5%;">Guanajoven</a>
    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>

    <ul class="right hide-on-med-and-down">
      <li><a href="../../../public/reportes">Reportes</a></li>
      <li><a href="../../../public/usuarios">Usuarios</a></li>
      <li><a href="../../../public/publicidad">Publicidad</a></li>
      <li><a href="../../../public/convocatorias">Convocatorias</a></li>
      <li><a href="../../../public/notificaciones">Notificaciones</a></li>
      <li><a href="../../../public/historial">Historial Notificaciones</a></li>
      <li><a href="../../../public/eventos">Eventos</a></li>
      <li><a href="../../../public/video">Video</a></li>
      <li><a href="../../logout.php">Cerrar sesión</a></li>
    </ul>
    <ul class="side-nav" id="mobile-demo">
        <li><a href="../../../public/reportes">Reportes</a></li>
        <li><a href="../../../public/usuarios">Usuarios</a></li>
        <li><a href="../../../public/publicidad">Publicidad</a></li>
        <li><a href="../../../public/convocatorias">Convocatorias</a></li>
        <li><a href="../../../public/notificaciones">Notificaciones</a></li>
        <li><a href="../../../public/historial">Historial Notificaciones</a></li>
        <li><a href="../../../public/eventos">Eventos</a></li>
        <li><a href="../../../public/video">Video</a></li>
        <li><a href="../../logout.php">Cerrar sesión</a></li>
   </ul>
  </div>
</nav>
'

 ?>
