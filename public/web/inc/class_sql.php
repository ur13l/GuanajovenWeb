<?php 
class DB_SQL {
	
	var $liga = NULL; var $texto = NULL; var $tipo = NULL; var $fecha_lan = NULL; var $nombre = NULL;
	var $hombre = 0; var $mujer = 0; var $gl = 0; var $pa = 0; var $lesion = 0; var $af = 0;  
	
	
	function connect($dbname){
		$this->connection = conexion_bd($dbname);
		$this->result = NULL;	
	}
	function query($query){
		$this->result = NULL;
		$time_inicio1 = microtime_float();
		$this->error = 0;
		$this->result = mysqli_query($this->connection, $query); 
		if (mysql_error()){
			$this->error = 1; 
			logError(002, mysql_error(). "<br>$query");
		}
		$time_final1 = microtime_float();
		$total1 = $time_final1 - $time_inicio1;
		//if($_SESSION['user']==1) 
		//	echo "$query<br> Time: $total1 <br>";
	}	
	function next_record_obj() {
		if ($this->result)	
			return $this->rs = mysqli_fetch_object($this->result);		
	}
	function next_record() {
		if ($this->result)	
			return $this->rs = mysqli_fetch_assoc($this->result);		
	}
	
	function f($reg){
		return $this->rs->$reg; 
	}
	
	function total_rows(){
		if ($this->result)
			$this->num_rows = mysqli_num_rows($this->result);
		else $this->num_rows = 0;	
		return $this->num_rows;
	}
	
	function close (){
		//mysql_close($this->connection);
		mysqli_free_result($this->result);
		//echo "Cnx: $this->connection <br> ";
		//if (pg_close($this->connection)) echo ">> Se cerro la conexion <br >";
		//echo "Cnx_despues: $this->connection <br> ";
		//$this->connection = NULL;
	}
	function _destruct(){
		//mysql_close($this->connection);
		//if (pg_close($this->connection))echo "Se cerro la conexion <br >";
		mysqli_free_result($this->result);
	} 
	
	function get_catalogo($tabla, $campos, $parametros,  $order=''){
		$query = "SELECT $campos FROM $tabla WHERE $parametros $order";
		$this->query($query);	
	}
	function get_catalogo2($tabla, $tabla2, $campos, $parametros,  $order=''){
		$query = "SELECT $campos FROM $tabla, $tabla2 WHERE $parametros $order";
		$this->query($query);	
	}
	/*function get_catalogo2($tabla, $tabla2, $campos, $parametros,  $order=''){
		$query = "SELECT $campos FROM $tabla, $tabla2 WHERE $parametros $order";
		$this->query($query);	
	} */
	
	function update_sql(){
		$str = '';
		foreach ($this->campo as $key => $val ){
			$str .=  " $key = '$val', ";	
		}
		$str = preg_replace( "/\,$/", " ", trim($str));
		$query = "UPDATE $this->tabla SET $str WHERE $this->keyy = $this->val_key";
		return $query;
	}
	function update_sql2(){
		$str = '';
		foreach ($this->campo as $key => $val ){
			$str .=  " $key = '$val', ";	
		}
		$str = preg_replace( "/\,$/", " ", trim($str));
		$query = "UPDATE $this->tabla SET $str WHERE $this->keyy = $this->val_key AND $this->keyy2 = $this->val_key2 ";
		return $query;
	}
	function update_sql3(){
		$str = '';
		foreach ($this->campo as $key => $val ){
			$str .=  " $key = '$val', ";	
		}
		$str = preg_replace( "/\,$/", " ", trim($str));
		$query = "UPDATE $this->tabla SET $str WHERE $this->keyy = $this->val_key AND $this->keyy2 = $this->val_key2 AND $this->keyy3 = $this->val_key3 ";
		return $query;
	}
	
	function insert_sql(){
		$strd = ''; $strv = '';
		foreach ($this->campo as $key => $val ){
			$strd .= " $key,  "; 
			$strv .=  " '$val', ";
		}
		$strd = preg_replace( "/\,$/", " ", trim($strd));
		$strv = preg_replace( "/\,$/", " ", trim($strv));
		$query = "INSERT INTO $this->tabla ($strd) VALUES ($strv)";
		/*if($_SESSION['user']==49){
			echo $query;
		}*/

		return $query;
	}
	function ejecutar_sql_sql(){
		
		if (!strcmp(gettype($this->val_key),"string"))
			$this->val_key = "'" . $this->val_key . "'";
		$query = sprintf("SELECT %s FROM %s WHERE  %s = %s", 
						$this->keyy,  $this->tabla, $this->keyy, $this->val_key );
		
		$this->query($query);
		if ($this->total_rows()){ 
			$query = $this->update_sql();
			$this->query($query);
			
		}else{ 
			$query = $this->insert_sql();
			$this->query($query);
			$this->val_key =  mysqli_insert_id($this->connection);
		}
		//echo "$query<br>";
		$this->get_datos_sql();
		return $this->error; 
		$this->error;
	}
	function ejecutar_sql_sql_load(){
		$query = sprintf("SELECT %s FROM %s WHERE  %s = %s", 
						$this->keyy,  $this->tabla, $this->keyy, $this->val_key );
		$this->query($query);
		if ($this->total_rows()){ 
			$query = $this->update_sql();
			$this->query($query);
			//$this->get_datos_sql();
		}else{ 
			$query = $this->insert_sql();
			$this->query($query);
			$this->val_key =  mysqli_insert_id($this->connection);
		}
		
		return $this->error;
	}
	function ejecutar_sql_sql2(){
		$query = sprintf("SELECT %s FROM %s WHERE  %s = %d AND %s = %d", 
						$this->keyy,  $this->tabla, $this->keyy, $this->val_key, $this->keyy2, $this->val_key2);
		$this->query($query);
		
		if ($this->total_rows()) 
			$query = $this->update_sql2();
		else 
			$query = $this->insert_sql();
		$this->query($query);
		
		return $this->error;
	}
	
	function ejecutar_sql_sql3(){
		$query = sprintf("SELECT %s FROM %s WHERE  %s = %d AND %s = %d AND %s = %d", 
						$this->keyy,  $this->tabla, $this->keyy, $this->val_key, $this->keyy2, $this->val_key2, $this->keyy3, $this->val_key3);
		$this->query($query);
		
		if ($this->total_rows()) 
			$query = $this->update_sql3();
		else 
			$query = $this->insert_sql();
		$this->query($query);
		
		return $this->error;
	}
	
	function get_datos_sql (){
		$query= sprintf("SELECT * FROM %s WHERE %s =%s", $this->tabla, $this->keyy, $this->val_key);
		$this->inicializar_tbl_sql();
		$this->query($query);
		if ($this->next_record()){
			foreach($this->rs as $key => $val){
				$this->$key = trim($val);
			}		
		}
		
	}
	function put_datos($table, $keyy, $val_key){
		$this->tabla = $table;
		$this->keyy = $keyy;
		$this->val_key = $val_key;
	
	}
	
	function get_datos_sqlq ($query){
		$this->query($query);
		if ($this->next_record()){
			foreach($this->rs as $key => $val){
				$this->$key = trim($val);
				//echo "$key $val";
			}		
		}
		return $this->total_rows();
	}
	function inicializar_tbl_sql(){
		$tabla = $this->tabla;
		$query = "SHOW COLUMNS FROM $tabla";
		$this->query($query);
		while ($this->next_record()){
			$key = $this->rs['Field'];
			if ($this->rs['Type'] == 'int(10) unsigned') 
				$this->$key = 0;
			else $this->$key = NULL;		
		}
	}	
	function rs_to_json($id, $text){
		$json = "[";
		$cont = 0;
		$json .= "{value:'', text:'Seleccione'},";
		while($this->next_record_obj()){
			$json .= "{value: " . $this->rs->$id . ",text:'" . $this->rs->$text. "'},";
			$cont++; 
		}
		$json = substr($json, 0, strrpos($json,","));
		$json .= "]";
		$this->json = $json;		
		return $this->json;
	}
	function get_datos ($tabla, $key_name, $key){
		//$this->connect("suhmdbsirh");
		$this->tabla = $tabla;
		$this->inicializar_tbl_sql();
		$query= "SELECT * FROM $tabla WHERE $key_name = $key";
		$this->get_datos_sqlq($query);
	}
	
	function set_first(){
		if ($this->result)
			mysqli_data_seek($this->result,0);	 
		
	} 
	
	//////////////////////////////////////////CREAR UPDATES//////////////////////////////////////////////////////////////////////////////////////////

	function create_update($tabla, $pref){
		foreach ($_POST as $key => $val){
			
			$k = NULL;
			if(($k = strstr( $key , $pref))){
				$k = substr($k,strlen($pref)); 
				$this->campo[$k] = $val;
			}elseif(($k = strstr( $key , "key"))){
				$k = substr($k,3);
				$this->keyy = $k;
				$this->val_key = $val;
			}
		} 
		$this->tabla = $tabla;
		$this->ejecutar_sql_sql();
		$this->campo=NULL;
		return $this->val_key;
	}

	function create_update_key($tabla, $pref){
		foreach ($_POST as $key => $val){
			$k = NULL;
			if(($k = strstr( $key , $pref))){
				$k = substr($k,strlen($pref));
				$this->campo[$k] = $val;
	
			}elseif(($k = strstr( $key , "key"))){
				$k = substr($k,3);
				$this->keyy = $k;
				$this->val_key = $val;
			}
		}
		$this->tabla = $tabla;
		$this->ejecutar_sql_sql();
		$this->campo=NULL;
		return $this->val_key;
}

function create_update2($tabla, $pref){
	foreach ($_POST as $key => $val){
		$k = NULL;
		if(($k = strstr( $key , $pref))){
			$k = substr($k,strlen($pref));
			$this->campo[$k] = $val;
			if (!strcmp($k, 'costo_estimado')){
				//$val = str_replace("$","", $val);
				//$val = str_replace(",","", $val);
				//$val = str_replace(" ","",$val);
				$p->campo[$k] = convertir_a_numero($val);
			}elseif (!strcmp($k, 'presupuesto_aut')){
				$val = str_replace("$","", $val);
				$val = str_replace(",","", $val);
				$val = str_replace(" ","",$val);
				$p->campo[$k] = $val;
			}elseif (!strcmp($k, 'costo')){
				$val = str_replace("$","", $val);
				$val = str_replace(",","", $val);
				$val = str_replace(" ","",$val);
				$p->campo[$k] = $val;
			}
		}elseif(($k = strstr( $key , "key1"))){
			$k = substr($k,4);
			$this->keyy = $k;
			$this->val_key = $val;
			
		}elseif(($k = strstr( $key , "key2"))){
			$k = substr($k,4);
			$this->keyy2 = $k;
			$this->val_key2 = $val;
		}
	}
	$this->tabla = $tabla;
	$this->ejecutar_sql_sql2();
	$this->campo=NULL;
	return $this->error; 
	}
function create_update3($tabla, $pref){
	foreach ($_POST as $key => $val){
		$k = NULL;
		if(($k = strstr( $key , $pref))){
			$k = substr($k,strlen($pref));
			$this->campo[$k] = $val;
		}elseif(($k = strstr( $key , "key1"))){
			$k = substr($k,4);
			$this->keyy = $k;
			$this->val_key = $val;
		}elseif(($k = strstr( $key , "key2"))){
			$k = substr($k,4);
			$this->keyy2 = $k;
			$p->val_key2 = $val;
		}elseif(($k = strstr( $key , "key3"))){
			$k = substr($k,4);
			$this->keyy3 = $k;
			$this->val_key3 = $val;
		}
	}
	$this->tabla = $tabla;
	$this->ejecutar_sql_sql3();
	$this->campo=NULL; 
	return $this->error; 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function get_ciudad_js(){
		//$json = new Services_JSON();
		$query = "SELECT * FROM municipios WHERE idestado = " . $this->idestado . " ORDER BY municipio ";
		$this->query($query);
		$ciudad = array();
		while($this->next_record_obj()){
			$ciudad[$this->rs->idmunicipio] = $this->rs->municipio;
		}
		return "(" . json_encode($ciudad) . ")";  
		 
	}
	function get_localidad_js(){
		//$json = new Services_JSON();
		$query = "SELECT * FROM localidades WHERE idmunicipio_int = " . $this->idmunicipio . " ORDER BY localidad ";
		$this->query($query);
		$localidad = array();
		while($this->next_record_obj()){
			$localidad[$this->rs->cvegeoestadistica] = $this->rs->localidad;
		}
		return "(" . json_encode($localidad) . ")"; 
	}
	
	function get_poligonos_js(){
		//$json = new Services_JSON();
		$query = "SELECT * FROM poligonos WHERE cve_loc = " . $this->idmunicipio . " ORDER BY nom_poli ";
		$this->query($query);
		$poligono = array();
		while($this->next_record_obj()){
			$poligono[$this->rs->idpoligono] = utf8_encode($this->rs->nom_poli);
		}
		return "(" . json_encode($poligono) . ")"; 
	}
	function get_colonias_js(){
		//$json = new Services_JSON();
		$query = "SELECT * FROM colonias WHERE idmunicipio = " . $this->idmunicipio . " ORDER BY colonia ";
		$this->query($query);
		$colonias = array();
		while($this->next_record_obj()){
			$colonias[$this->rs->idcolonia] = utf8_encode($this->rs->colonia);
		}
		return "(" . json_encode($colonias) . ")"; 
	}
	
	
}


 ?>
