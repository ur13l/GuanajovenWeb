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
  <title>Login</title>
  <link rel="stylesheet" href="../../materialize/css/materialize.min.css">
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/lolliclock.css">
  <link rel="stylesheet" href="../../css/toastr.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script type="text/javascript" src="../../js/jquery-1.12.3.js"></script>
  <script type="text/javascript" src="../../js/lolliclock.js"></script>
  <script type="text/javascript" src="../../materialize/js/materialize.js"></script>
  <script type="text/javascript" src="../../js/moment.js"></script>
  <script type="text/javascript" src="../../js/toastr.min.js"></script>
  <script type="text/javascript" src="../../js/jquery.twbsPagination.min.js"></script>
  <script type="text/javascript" src="../../js/eventos.js"> </script>

</head>
<body>
  <?php
  include("../defines/nav.php");
  ?>
  <div class="container">
    <div class="row">
      <table class="highlight">
        <thead>
          <tr>
            <th data-field="titulo">Título</th>
            <th data-field="descripcion">Descripción</th>
            <th data-field="fecha_inicio">Inicia</th>
            <th data-field="fecha_fin">Termina</th>
            <th data-field="tipo">Tipo</th>

          </tr>
        </thead>

        <tbody id="tabla-eventos">

        </tbody>
      </table>
    </div>
    <a href="#modal1" class="btn-floating btn-large waves-effect waves-light red right btn modal-trigger">
      <i class="material-icons" id="new-event">add</i>
    </a>
<ul id="pagination-demo" class="pagination-sm"></ul>

    <!-- Modal Structure -->
    <div id="modal1" class="modal">
      <div class="modal-content">
        <h4>Detalles del evento</h4>
        <p>
          <div class="row">
            <form class="col s12">
              <div class="row">
                <div class="input-field col s12">
                  <input id="titulo" type="text" class="vald">
                  <label for="titulo">Título</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <textarea id="descripcion" class="materialize-textarea vald"></textarea>
                  <label for="descripcion">Descripción</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6">
                  <input id="fecha-inicio" type="text" class="datepicker vald" >
                  <label for="fecha-inicio">Fecha de inicio</label>
                </div>
                <div class="input-field col s6">
                  <input id="hora-inicio" type="text" class="timepicker vald">
                  <label for="hora-inicio">Hora de inicio</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6">
                  <input id="fecha-fin" type="text" class="datepicker vald">
                  <label for="fecha-fin">Fecha de finalización</label>
                </div>
                <div class="input-field col s6">
                  <input id="hora-fin" type="text" class="timepicker vald">
                  <label for="hora-fin">Hora de finalización</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <select required id="tipo" class="validate">
                    <option value="" disabled>Elige una opción</option>
                    <option value="1" selected>Competencia de deportista olímpico</option>
                    <option value="2">Información general</option>
                  </select>
                  <label>Tipo de evento</label>
                </div>

              </div>
            </form>
          </div>
        </p>
      </div>
      <div class="modal-footer">
        <a href="#!" class=" modal-action waves-effect waves-green btn-flat" id="guardar-evento">Guardar</a>
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
      </div>
    </div>

  </div>
</body>
</html>
