<?php
//header('Content-Type: application/json; charset=utf-8');

include("./common.php");
require_once("./class_sql.php");

ini_set("display_errors","1");
		
		
		$str = "";
		
		$rs = new DB_SQL();
		$rs->connect("appbd");
		
		(!isset($_POST['act_hombre']))?$_POST['act_hombre']=0 : '' ;
        (!isset($_POST['act_mujer']))?$_POST['act_mujer']=0 : '' ;
        (!isset($_POST['act_pa']))?$_POST['act_pa']=0 : '' ;
        (!isset($_POST['act_gl']))?$_POST['act_gl']=0 : '' ;
        (!isset($_POST['act_af']))?$_POST['act_af']=0 : '' ;
        (!isset($_POST['act_lesion']))?$_POST['act_lesion']=0 : '' ;

		$fileName = $_FILES["file1"]["name"]; // The file name
		$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
		$fileType = $_FILES["file1"]["type"]; // The type of file it is
		$fileSize = $_FILES["file1"]["size"]; // File size in bytes
		$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
		
		$ext = explode(".",$fileName);

		if (!$fileTmpLoc) { // if file not chosen
			echo $rs->create_update("tipsandtricks","act_");
		    echo '{"success":"true"}';
			echo "ERROR: Please browse for a file before clicking the upload button.";
			exit();
		}else{    
		
		$tipo = $_POST['act_tipo'];	
		switch($tipo){
			case '1':{
				$ruta = "../../res/repo/images/";
			}
		    break;
			case '2':{
				$ruta = "../../res/repo/images/";
			}
		    break;
			case '3':{
				$ruta = "../../res/repo/video/";
			}
		    break;	 
			default:	
					$ruta = "../../res/repo/default/";
			break;
		}
		  
		if($_POST['act2_nombre']== ""){
			$name = "tip".$_POST['act_tipo']."-".time(); 	
			$rutacompleta= $ruta.$name.".".$ext[1];
			
			$_POST['act_nombre'] = $name.".".$ext[1];	
			$_POST['act_ruta']	= $ruta;
		}else{
			$name = $_POST['act2_nombre']; 	
			$rutacompleta= $ruta.$name;
			
			$_POST['act_nombre'] = $name;	
			$_POST['act_ruta']	= $ruta;
		}	
		
		
	  if(move_uploaded_file($fileTmpLoc, $rutacompleta)){

		  echo $rs->create_update("tipsandtricks","act_");
		  echo '{"success":"true"}';
		} else {
			echo $fileTmpLoc;
			echo "move_uploaded_file function failed";
		}
		}
	
?>