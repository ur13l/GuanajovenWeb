<?php
#Autor: Luis Alberto Garcidueñas Guerrero
#Controlador para cargar el video por día.
#Fecha: 20/06/2016
#
ini_set('display_errors','1');
$bandera = "";

include("../../app_php/conexion/conexion.php");

echo $dia = date("N");
//$dia = 4;
switch( $dia ){
	case 1: if (copy("../../res/video/semana/1.mp4", "../../res/video/video.mp4")) {
    				$fileSize = filesize("../../res/video/semana/1.mp4");
					$bandera = true;
				}else{				    
					$bandera = false;
			    }		  
	 break;
	 case 2: if (copy("../../res/video/semana/2.mp4", "../../res/video/video.mp4")) {
		 			$fileSize = filesize("../../res/video/semana/2.mp4");
    				$bandera = true;
				}else{				    
					$bandera = false;
			    }			
	 break;
	 case 3: if (copy("../../res/video/semana/3.mp4", "../../res/video/video.mp4")) {
		 			$fileSize = filesize("../../res/video/semana/3.mp4");
    				$bandera = true;
				}else{				    
					$bandera = false;
			    }			
	 break;
	 case 4: if (copy("../../res/video/semana/4.mp4", "../../res/video/video.mp4")) {
		 			$fileSize = filesize("../../res/video/semana/4.mp4");
    				$bandera = true;
				}else{				    
					$bandera = false;
			    }			
	 break;
	 case 5: if (copy("../../res/video/semana/5.mp4", "../../res/video/video.mp4")) {
		 			$fileSize = filesize("../../res/video/semana/5.mp4");
    				$bandera = true;
				}else{				    
					$bandera = false;
			    }			
	 break;
	 case 6: if (copy("../../res/video/semana/6.mp4", "../../res/video/video.mp4")) {
		 			$fileSize = filesize("../../res/video/semana/6.mp4");
    				$bandera = true;
				}else{				    
					$bandera = false;
			    }			
	 break;
	 case 7: if (copy("../../res/video/semana/7.mp4", "../../res/video/video.mp4")) {
		 			$fileSize = filesize("../../res/video/semana/7.mp4");
    				$bandera = true;
				}else{				    
					$bandera = false;
			    }			
	 break;

		default:  
				$bandera = false; 
				break;

}


if($bandera == true){
	$conexion = connect();
	$consulta = "INSERT INTO video VALUES (1, now(), '$fileSize') ON
					  DUPLICATE KEY UPDATE fecha_actualizacion = now(), tamano = '$fileSize'";
	echo $consulta;
	mysqli_query($conexion, $consulta);
	$conexion->close();
	echo '{"success":"true"}';
}else{
	echo "Error";
}


?>

