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
  <title>Historial de Notificaciones</title>
  <link rel="stylesheet" href="../../materializeb/css/materialize.css">
  <link rel="stylesheet" href="../../css/style.css">
<!--  <link rel="stylesheet" href="../../js/Bootstrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../../js/Bootstrap/css/bootstrap-theme-blue-mode.css"/>-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script type="text/javascript" src="../../js/jquery-1.12.3.js"></script>
  

  <script type="text/javascript" src="../../materializeb/js/materialize.js"></script>
 <!-- <script src="../../js/Bootstrap/js/bootstrap.js"></script>--> 
    <script type="text/javascript" src="../../js/js_historial.js"></script>
  
  
  <!-- DataTables -->
<!--<script src="../../js/jquery-1.12.3.js"></script>-->
<script src="../../js/DataTables/js/jquery.dataTables.js"></script>
<script src="../../js/DataTables/js/dataTables.material.js"></script>
<script src="../../js/DataTables/extensions/Responsive/js/dataTables.responsive.js"></script>
<script src="../../js/DataTables/extensions/Buttons/js/dataTables.buttons.js"></script>
<script src="../../js/DataTables/extensions/Buttons/js/buttons.html5.js"></script>
<script src="../../js/DataTables/extensions/Buttons/js/jszip.js"></script>
<script src="../../js/DataTables/extensions/Buttons/js/pdfmake.min.js"></script>
<script src="../../js/DataTables/extensions/Buttons/js/vfs_fonts.js"></script>
<script src="../../js/DataTables/extensions/Buttons/js/buttons.print.js"></script>
<link rel="stylesheet" type="text/css" href="../../js/DataTables/css/dataTables.material.css">
<!--<link rel="stylesheet" type="text/css" href="../../../historial/js/DataTables/extensions/Responsive/css/responsive.bootstrap.css">-->
<link rel="stylesheet" type="text/css" href="../../js/DataTables/extensions/Buttons/css/buttons.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css">

<!-- -->
 

  
 

</head>
<body style="background:#f1f1f1">
  <?php
    include("../defines/nav.php");
    include('../defines/checkLogin.php');
 ?>

  <div class="container"  >
    <div class="section">   
         <button onClick="reg_tip(0)" class="btn rose_code" style="background: #BF3364;">Tip Nuevo</button>
     <div class="row">
        <div class="col s12 m12">
          
          <table id='example'  class='table table-striped table-bordered table-hover dt-responsive ' cellspacing='0' width='100%' >
  <thead><tr>
          <th class=''>Nombre</th>
          <th class=''>Tipo</th>
          <th class=''>Liga</th>
          <th class=''>Texto</th>
          <th class=''>Fecha Pub</th>
          <th class=''>Fecha Reg</th>
          <th class=''>Acciones</th>    
           
    </tr></thead>
</table>    
      </div>

      </div>
      

      
      

	<!-- Modal -->
	<div class="modal" id="myModal">

			<div class="modal-content" id='modalData'>

			</div> <!-- /.modal-content -->

	</div> <!-- /.modal -->                 

      
      
	</div>
  </div><!-- container -->    
</body>
</html>
