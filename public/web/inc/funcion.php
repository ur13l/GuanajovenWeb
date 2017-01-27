<?php
//header('Content-Type: application/json; charset=utf-8');

include("./common.php");
require_once("./class_sql.php");

ini_set("display_errors","1");



	function cargar(){

		$str = "";
		
		$rs = new DB_SQL();
		$rs->connect("appbd");
		
		$str = "SELECT e.*,t.tipo_tip FROM tipsandtricks e LEFT JOIN tipo_tips t ON (e.tipo = t.idtipo) WHERE e.vigente = 1 ";
		
		
		
		$list = "";
		$cont=0; 
		
		$str1="";
		$resultado = "";
		$fila = ""; 
		$columnas="";
		$datos = "";
		
		
		
									
				
		$columnas[0] = "e.nombre";
		$columnas[1] = "tipo_tips";
		$columnas[2] = "e.liga";
		$columnas[3] = "e.texto";
		$columnas[4] = "e.fecha_lan";
		$columnas[5] = "e.fecha";
		
				
		
		
		
		///// BUSQUEDAS ENTRE LOS CAMPOS ////

if ( isset($_GET['search']) && $_GET['search']['value'] != '' ) {
			
			$i = 0;
			$str .= " AND (";
			foreach($columnas as $col){
				//$col = "f.".$col;
				if($i == 0){
					$str .= " $col LIKE  '%". $_GET['search']['value'] ."%'";
				}else{
					$str .= " OR  $col LIKE  '%". $_GET['search']['value'] ."%'";
				}
			$i++;
			
			
			}
			$str .= ")"; 	
 
}
		//echo $str;
        
        $rs->query($str);			
		
		$totalcompleto = $rs->total_rows();	
 


//// ORDENAR ////

if ( isset($_GET['order']) && count($_GET['order']) ) {
			$orderBy = array();
			
			for ( $i=0, $ien=count($_GET['order']) ; $i<$ien ; $i++ ) {
				// Convert the column index into the column data property
				$columnIdx = intval($_GET['order'][$i]['column']);
				$requestColumn = $_GET['columns'][$columnIdx];

				$columnIdx = array_search( $requestColumn['data'], $columnas );
				$column = $columnas[ $columnIdx ];

				if ( $requestColumn['orderable'] == 'true' ) {
					$dir = $_GET['order'][$i]['dir'] === 'asc' ?
						'ASC' :
						'DESC';
						//$column = "f.".$column;	
						//if($column == "folio"){
							//$column = $column ."+0"; //ordenas numericamente campo de texto...
						//}
				     $orderBy[] = $column." ".$dir;
				}
			}

			$str .= ' ORDER BY '.implode(', ', $orderBy);
} 



////FILTRAR POR PAGINA ////
		if ( isset($_GET['start']) && $_GET['length'] != -1 ) {
					$limit = "LIMIT ".intval($_GET['start']).", ".intval($_GET['length']);
					$str1 .= $str." ".$limit;
		}elseif ($_GET['length'] == -1) {
			$str1 .= $str;
		}	


 		
        $rs->query($str1);	 

		
		$total = $rs->total_rows(); 
	

		while($rs->next_record_obj()){
				
			
			$editar = "			          
			          <a  onClick='reg_tip(".$rs->rs->id_tips.")' > <img   src='../../res/img/edit.png' title=\"Editar\" width='32px' height='32px' /></a> ";
			
				  
			
				$acciones = "$editar";
			

				

			$datos[$cont] = array( 

	  			$rs->rs->nombre,
				utf8_encode($rs->rs->tipo_tip),
				$rs->rs->liga,
				$rs->rs->texto,
				convertir_fecha($rs->rs->fecha_lan,2),
				convertir_fecha($rs->rs->fecha,4),
				$acciones
			
				
				  
				 
	   	);
	 $cont++;
	 
	 }
	 
	$datos1[0] = array( 'draw' => $_GET['draw'],
  					'recordsTotal' => $total,
				    'recordsFiltered'=> $totalcompleto,
					'data' => $datos);

	echo json_encode($datos1[0]); 
		


	}
	
	
	cargar(); 

?>