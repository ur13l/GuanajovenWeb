<?php 
include("./common.php");
require_once("./class_sql.php");

ini_set("display_errors","1");

switch( $_GET['cmd'] ){
	case 'add_reg':  echo reg_equipo();		
	break;
	
	
	
}


function reg_equipo(){
    
	
	$id = $_GET['id'];
	$p = new DB_SQL();
	$p->connect("appbd");
	
	$str = "SELECT * FROM tipsandtricks  WHERE id_tips = $id";
	
	$p->get_datos_sqlq($str);
	
	($p->hombre == 1)? $chkh="checked" : $chkh='' ;
	($p->mujer == 1)? $chkm="checked" : $chkm='' ;
	($p->pa == 1)? $chkpa="checked" : $chkpa='' ;
	($p->gl == 1)? $chkgl="checked" : $chkgl='' ;
	($p->af == 1)? $chkaf="checked" : $chkaf='' ;
    ($p->lesion == 1)? $chkles="checked" : $chkles='' ;
	($p->nombre != NULL)? $archivo = $p->ruta.$p->nombre : $archivo = '';
		
$form = "<html>
<head>
  <meta http-equiv='content-type' content='text/html; charset=UTF-8'>
  <title>Remote file for Bootstrap Modal</title>  
</head>
<style type='text/css'>
	.input-field label, input, select {
     
    font-size: 18px !important;
    }
</style>
<script>
/**
 * Función que valida si un campo de texto está vacío, marca el error en la interfaz.
 * @param  input: Recibe el elemento visible que contiene el texto.
 * @return {Boolean} true si el campo está vacío, false de lo contrario.
 */
function isEmpty(input){
    if(input.val().length > 0){
      return false;
    }
    else {
      input.addClass('invalid');
    }
}

/**
 * N
 * @param  {[type]} select [description]
 * @return {[type]}        [description]
 */
function noOpcion(select){
  if(select.val()){   
    return false;
  }
  else {
    select.css({'border-color':'#EA454B','box-shadow':'0 1px 0 0 #EA454B'});
  }
}

$(document).ready(function() {
    $('select').material_select();
	
	Materialize.updateTextFields();  
         
	});
 
</script>
<body>
            <div class='modal-header' >
               
                 <!--<h4 class='modal-title'>Registro de Historial</h4> <br />-->
            </div>			
            <div class='modal-body'>
           	<div class='row'>
               <form class='' id='floatForm' name='floatForm' method='post' enctype='multipart/form-data' action='#'>
			  
			   <input type=\"hidden\" name=\"keyid_tips\" id=\"keyid_tips\" value=\"".$id."\">
			   <input type=\"hidden\" name=\"act2_nombre\" id=\"act2_nombre\" value=\"".$p->nombre."\">

<input type=\"hidden\" name=\"act_fecha\" id=\"act_fecha\" value=\"". date('Y-m-d') ."\" />
  
                         <div class='row'>         
                          <div class='input-field col s10 offset-s1'>              
                               <label for='act_liga' >Liga </label>             
                              <input name=\"act_liga\" type=\"text\" class=\" val active\" id=\"act_liga\"  value=\"" . $p->liga . "\" placeholder='' />           </div>    
                          </div>               
				      
					 <div class='row'>         
                          <div class='input-field col s10 offset-s1'>                   
                               <label for='act_texto' >Texto </label>             
                                         <input name=\"act_texto\" type=\"text\" class=\" val\" id=\"act_texto\"  value=\"" . $p->texto . "\" placeholder=\" \" />
                                                
                           </div>               
				        </div>               
				      
					 <div class='row'>         
                          <div class='input-field col s5 offset-s1'>                   
                               <label for='act_fecha_lan' >Fecha Lanzamiento </label>             
                                         <input name=\"act_fecha_lan\" type=\"text\" class=\" \" id=\"act_fecha_lan\"  value=\"" . $p->fecha_lan . "\" placeholder=\"2016-11-01 \" />
                                                
                           </div>               
				    			    
					<div class='input-field col s5 '>
					  <select  id='act_tipo' name='act_tipo' >
						<option value='0' disabled>Elige una opción</option>";
				$form .=  utf8_encode(fill_combo("appbd", "tipo_tips", "idtipo", "tipo_tip", $p->tipo));
				$form .="</select>
					  <label>Tipo </label>
					</div>
			   </div>
					 
					 
				   	
					 <div class='row'> 
					  <div class='input-field col s10 offset-s1'>
		  				  <input type='checkbox' id='act_hombre' name='act_hombre' ".$chkh." />
						  <label for='act_hombre''>Hombres</label>
					    &nbsp; &nbsp;
						  <input type='checkbox' id='act_mujer' name='act_mujer' ".$chkm." />
						  <label for='act_mujer''>Mujeres</label>
					  </div>
					 </div>
					   
					 <div class='row'> 
					  <div class='input-field col s10 offset-s1'>
						  <input type='checkbox' id='act_pa' name='act_pa' ".$chkpa." />
						  <label for='act_pa'>Presión Arterial</label>
					    &nbsp; &nbsp;
						  <input type='checkbox' id='act_gl' name='act_gl' ".$chkgl." />
						  <label for='act_gl'>Glucosa</label>
						&nbsp; &nbsp;
						  <input type='checkbox' id='act_af' name='act_af'  ".$chkaf." />
						  <label for='act_af'>Actividad Física</label>
						&nbsp; &nbsp;
						  <input type='checkbox' id='act_lesion' name='act_lesion'  ".$chkles." />
						  <label for='act_lesion'>Lesión</label>   
					  </div>
					 </div>
					
					<div class='row'>
					<div class='input-field col s10 offset-s1'>
						<div class='file-field input-field' >
						  <div class='btn'>
							<span>Examinar</span>
							<input type='file' name='file1' id='file1' >
						  </div> 
						  <div class='file-path-wrapper'>
							<input class='file-path validate' type='text'>
						  </div>
						</div>
					</div>
					</div>
					<div class='progress'>
					      <div class='determinate' style='width: 0%'></div>
					</div>				
					<div class='row'>
					
				      <img src='$archivo' class='col s9 m6 l3 offset-s2 offset-m3 offset-l4'>
					
					</div>
					  
				</form>                 			
		    </div>								
			
		   
		   
		   
		   
		    
            </div>			<!-- /modal-body -->
            <div class='modal-footer'>
                <a id='btnGuardar' onClick='save_registro()' class='modal-action  waves-effect waves-green btn-flat '>Guardar</a>
				<a  class='modal-action modal-close waves-effect waves-green btn-flat '>Cancelar</a>
            </div>			<!-- /modal-footer -->
</body>
</html>";	


	return $form;

}



?>

