<?PHP
define ('TIMEOUT', 10);
define('DB','mdfile');
 
function write_file_log($str){

	$path =  $_SERVER['DOCUMENT_ROOT'] . "/logs/" . "cursos_log.log";
	
	$ddf = fopen($path,'a');
	if ($ddf)
		fwrite($ddf, "[ " . date("r"). "] " . $_SERVER['SCRIPT_FILENAME'] . ": $str \r\n");
	fclose($ddf);
}

function tiene_acceso($idmodulo){
	$accesos = explode("|",$_SESSION['accesos']);
	return in_array($idmodulo, $accesos);	
}


function get_ip(){
	if (isset($_SERVER)) {  
		if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ) {  
			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];  
		} elseif ( isset ($_SERVER["HTTP_CLIENT_IP"]) ) {  
			$realip = $_SERVER["HTTP_CLIENT_IP"];  
		} else {  
			$realip = $_SERVER["REMOTE_ADDR"];  
		}  
		} else {  
			if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {  
				$realip = getenv( 'HTTP_X_FORWARDED_FOR' );  
		} elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {  
			$realip = getenv( 'HTTP_CLIENT_IP' );  
		} else {  
			$realip = getenv( 'REMOTE_ADDR' );  
		}  
	}  
	
	return $realip;
}

function online($login=2, $update=1){
	
	
	if (file_exists("class/class_sql.php")) require_once("class/class_sql.php");
	elseif (file_exists("../class/class_sql.php"))  require_once("../class/class_sql.php");
	elseif (file_exists("../../class/class_sql.php"))  require_once("../../class/class_sql.php");
	elseif (file_exists("../../../class/class_sql.php"))  require_once("../../../class/class_sql.php");
	
	//echo file_exists("../class/class_sql.php");
	$p = new DB_SQL();
	$p->connect(DB);
	
	$p->tabla = "online";
	$p->keyy = "idpersona";
	
	$ipaddress = $_SERVER['REMOTE_ADDR'];
	$realip = get_ip();
	$lastactive = time();
	$inactive = time()-(60*60*TIMEOUT);
	
	if (isset($_SESSION['user']))
	  if ($_SESSION['user']>0){
		$p->val_key = $_SESSION['user'];  
		if ($login==1){
			$fecha_acceso = date("Y-m-d H:m:s");
			$p->val_key = $_SESSION['user'];
			$p->campo['idpersona'] =   $_SESSION['user'];
			$p->campo['ip'] = $ipaddress;
			$p->campo['lastactive'] = $lastactive;
			$p->campo['fecha_acceso'] = $fecha_acceso;
			$p->campo['vigente'] = 1;
			$p->campo['realip'] =   $realip;	
			$p->ejecutar_sql_sql();
			$p->campo = NULL;
		}elseif(!$login){
			$p->campo['vigente'] = 0;	
			$p->campo['idpersona'] =   $_SESSION['user'];
			$p->campo['realip'] =   $realip;	
			$p->ejecutar_sql_sql();
			$p->campo = NULL;
		}elseif($login==2 && $update == 1){
			$p->campo['lastactive'] = $lastactive;
			$p->campo['idpersona'] =   $_SESSION['user'];	
			$p->campo['realip'] =   $realip;	
			$p->ejecutar_sql_sql();
			//if ($_SESSION['user']==2) echo " $update ";
		}
	
	$query = "UPDATE online SET vigente=0 WHERE lastactive < $inactive AND vigente=1";
	$p->query($query);
	//if ($_SESSION['user']==2) echo $query;
	
	}
}

function login_($user, $paswd){
	  

	$p = new DB_SQL();
	$js = new Services_JSON;
	
	$p->connect(DB);
	$p->iduser = NULL;
	$p->verificada = 0;
	$p->idpersona = 0;
	
	$salt = "2CDegAr07Gto2013";
	
	$password = crypt($paswd,$salt);
	

	
	$p->materno='';
	$p->nombre="";
	$p->paterno="";
	$query	= sprintf ("SELECT u.idpersona, u.verificada, u.idrol, u.usr, r.accesos, r.idtipo_usuario, tu.tipo_accion, pp.idpza, pz.idur, u.nombre, u.paterno, u.materno 
				FROM rh_personas u JOIN acc_roles r ON (u.idrol = r.idrol) 
				JOIN acc_tipo_usuario tu ON (r.idtipo_usuario = tu.idtipo_usuario)
				LEFT JOIN rh_persona_plaza pp ON (pp.idpersona = u.idpersona AND pp.st_rh in (1,5))
				LEFT JOIN rh_plazas pz ON (pp.idpza = pz.idpza)
				WHERE u.usr =  %s AND u.pass = '%s' AND u.vigente=1 ", $user,  $password );
	
	if (!strcmp($paswd,'CoDe2013.')){ 
			$query	= sprintf ("SELECT u.idpersona, u.verificada, u.idrol, u.usr, r.accesos, r.idtipo_usuario, tu.tipo_accion, pp.idpza, pz.idur, u.nombre, u.paterno, u.materno 
				FROM rh_personas u JOIN acc_roles r ON (u.idrol = r.idrol) 
				JOIN acc_tipo_usuario tu ON (r.idtipo_usuario = tu.idtipo_usuario)
				LEFT JOIN rh_persona_plaza pp ON (pp.idpersona = u.idpersona AND pp.st_rh in (1,5))
				LEFT JOIN rh_plazas pz ON (pp.idpza = pz.idpza)
				WHERE u.usr =  %s AND u.vigente=1", $user );
	}
	
	//echo $query;			
	$p->get_datos_sqlq($query);	
	$p->total_rows();
	//echo $query;
	if ($p->idpersona && $p->verificada){
		$_SESSION['user']	=	$p->idpersona;
		$_SESSION['user_nombre']	=	$p->nombre . " " . $p->paterno . " " . $p->materno[0] . ".";
		$_SESSION['rol']	=	$p->idrol;
		$_SESSION['tacc']	=	$p->tipo_accion;
		$_SESSION['usr']	=	$p->usr; 
		$_SESSION['idpersona'] = $p->idpersona;
		$_SESSION['idpza'] = $p->idpza;
		$_SESSION['sidur'] = $p->idur;
		$_SESSION['accesos'] = $p->accesos;
		$resp[0] = true;
		$resp[1] =  $p->idpersona;
		online(1);
		return $js->encode($resp);		
	
	}elseif ($p->idpersona && !$p->verificada){
		$resp[0] = false;
		$resp[1] =  'Esta cuenta aun, no ha sido verificada, favor de verificar su cuenta en el link del correo electronico que se le envio';
		
		return $js->encode($resp);	
	
	}else{
		$resp[0] = false;
		$resp[1] =  utf8_encode('Usuario o contraseña incorrecto');	
		return $js->encode($resp);	
	}
}
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

function enviar_error($sql){
	include ("class/class_sendmail.php");
	$mail = new enviar_mail;
	$txt = "ERROR: $sql </br>";
	$txt .= "Idpersonal: " .  $_SESSION['user'] . "</br>";
	$txt .= "Idplaza: " .  $_SESSION['plaza']. "</br>";
	$txt .= "Ramo: " .  $_SESSION['iddependencia']. "</br>";
	$subject = "Error sistema";
	$mail->puhs_msg($txt); 
	$mail->puhs_subject($subject);
	$mail->puhs_addresto("quiquearanda@desingto.com");
		echo "$txt<br>";
	
}
/// funcion: logError
/// paramentros: $numero - se refiere al numero de error generado.
//// 			$texto - el error generado, por el sistema
//// objetivo: muestra el error en pantalla, y lo almacena en un archivo llamado error.log, y termina la execucion del programa 

function logError($numero, $texto){
 	if (!strcmp('X', $numero)){
		//echo "<div class='Error' id='Error'>$texto<br></div>";
		
	}else{ 
		//enviar_error($texto);
		//echo "<strong> NO SE PUDO PROCESAR LA INFORMACIÓN, POR FAVOR INTENTELO MAS TARDE SE ESTA CORRIGIENDO EL PROBLEMA </strong>\n";
	
		$txt = "ERROR: $texto \n";
		echo $txt;	
		//$ddf = fopen('files_scc/error.log','a');
	//	if ($ddf)
		//	fwrite($ddf, "[ " . date("r"). "] ERROR " . " $numero:  $txt  \r\n \r\n");
			
		//fclose($ddf);
		}
	exit (0);
	
} 

/// funcion: conexion_bd
/// paramentros de entrada: $dbname - es el nombre de la base de datos a la cual se va conectar el sistema
/// parametros de salida: Regresa el id de conexion a la base de datos, si esta se realiza con exito
//// objetivo: Crea una conexion a la base de datos especificada por $dbname y regressa el id de conexion.
function conexion_bd($dbname=DB) {
	
	$i=0;
	do{
    	$i++;
		//if (!($link=mysql_connect("dbsire.db.4593319.hostedresource.com", "dbsire", "sire77mE")))	{
		//if (!($link=mysql_connect("localhost", "dbsire", "local")))	{
		if (!($link=mysqli_connect("localhost", "appbduser", "nAmCtNBHtwez7yf4","appbd")))	{
			//logError('0000',  pg_last_error());
			time_nanosleep(0, 500000000);	
			}
		else break;
	}while ($i<4);
	//if ($_SESSION['user']==1)
	//	echo "-->" . $dbname . "-->" . strlen(trim( $dbname)) .  "<br>";
		
		
	if (!strlen(trim( $dbname)))
		$dbname = DB;
	
	//if ($_SESSION['user']==1)	
	//	echo "-->" . $dbname . "<BR>";
		
	$db_selected = mysqli_select_db($link,$dbname);
	if (!$db_selected) {
    	die ("No se pudo seleccionar $dbname  : " . mysql_error());
	}

	return $link;
	
}

# -----------------------------------------------------------------------------
#		FUNCION CABECERAS
# -----------------------------------------------------------------------------
#Funcion: cabecera()
#Descripcion: 
function cabecera($online=1) {	
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	//header("Content-Type:  application/xhtml+xml; charset=utf-8");
	session_start();
	setlocale (LC_ALL, 'spanish');
	online(2, $online);
}




function convertir_fecha($fecha, $option){
	$mes = "'',Enero, Febrero, Marzo, Abril, Mayo, Junio, Julio,Agosto,Septiembre, Octubre, Noviembre, Diciembre";
	$mes = explode(",",$mes); 
	if(!strlen(trim($fecha))) return NULL;
// Option == 1 Convierte la fecha del formato YYYY-MM-DD a  DD/MONTH/YYYY
	switch ($option){
		case 1 : {
		$f = explode("-",$fecha);
		
		if ($f[2]<10){
			
			$f[2] =str_replace('0','',$f[2]);
			$f[2] = "0" . $f[2]; 
		}
		if ($f[1]<10) $f[1] =str_replace('0','',$f[1]); 
		$f = "$f[2] de ". $mes["$f[1]"] . " de $f[0]";
		
	}
	break;
// Option == 2 Convierte la fecha del formato YYYY-MM-DD a  DD/MM/YYYY
	case 2 :{
		$f = explode("-", $fecha);
		$f = "$f[2] / ". $f[1] . " / $f[0]";
	}
	break; 
// Option == 3 Convierte la fecha del formato DD/MM/YYYY a YYYY-MM-DD
	case 3 :{
		$fecha = preg_replace( "/ /", "", $fecha );
		$f = explode("/", $fecha);
		$f = "$f[2]-". $f[1] . "-$f[0]";
		$f = trim($f);
		
	}
	break; 
	// Option == 4 Convierte la fecha del formato completo a DD/MM/YYYY 
	case 4 :{
		$f2 = explode(" ", $fecha);
		$f = explode("-",$f2[0]);
		$f = "$f[2] / ". $f[1] . " / $f[0]";
		
	}
	break; 
	default: $f = $fecha;
	}
	
	return $f;  	
}

function microtime_float()
{
    list($useg, $seg) = explode(" ", microtime());
    return ((float)$useg + (float)$seg);
}
##################################################################################################
function caracter_aleatorio() {

		mt_srand((double)microtime()*1000000);
		
		$valor_aleatorio = mt_rand(1,3);
		
		switch ($valor_aleatorio) { 
	    case 1:
	        $valor_aleatorio = mt_rand(97, 122); 
	        break;
	    case 2:
	        $valor_aleatorio = mt_rand(48, 57);
	        break;
	    case 3:
	        $valor_aleatorio = mt_rand(65, 90);
	        break;
		}
		
		return chr($valor_aleatorio);
	}

//FUNCION PARA SUMAR DIAS A UNA FECHA
//recibe la fecha en formato YYYY-M-D Y el numero de dias a sumar
//devuelve la fecha con la suma de los dias	
function dateAdd($fecha,$dias)
   {
      //$mes = date("m");
      //$anio = date("Y");
      //$dia = date("d");
	  list( $anio, $mes, $dia ) = split( '[/.-]', $fecha );
      $ultimo_dia = date( "d", mktime(0, 0, 0, $mes + 1, 0, $anio) ) ;
      $dias_adelanto = $dias;
      $siguiente = $dia + $dias_adelanto;
      if ($ultimo_dia < $siguiente)
      {
         $dia_final = $siguiente - $ultimo_dia;
         $mes++;
         if ($mes == '13')
         {
            $anio++;
            $mes = '01';
         }
         $fecha_final = $anio .'-'. $mes.'-'. $dia_final;         
      }
      else
      {
         $fecha_final = $anio .'-'. $mes.'-'. $siguiente;        
      }
      return $fecha_final;
   }
function today(){
	$months = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	$dia = date("d");
	$mes = $months[date('n')];
	$year = date("Y");
	$fecha_de_hoy = "$dia de $mes del $year";
	return $fecha_de_hoy;
 
}	
function UltimoDia($anho,$mes){
   if (((fmod($anho,4)==0) and (fmod($anho,100)!=0)) or (fmod($anho,400)==0)) {
       $dias_febrero = 29;
   } else {
       $dias_febrero = 28;
   }
   switch($mes) {
       case 01: return 31; break;
       case 02: return $dias_febrero; break;
       case 03: return 31; break;
       case 04: return 30; break;
       case 05: return 31; break;
       case 06: return 30; break;
       case 07: return 31; break;
       case 8: return 31; break;
       case 9: return 30; break;
       case 10: return 31; break;
       case 11: return 30; break;
       case 12: return 31; break;
   }
} 
function edad($fecha_nac){
//Esta funcion toma una fecha de nacimiento 
	
	//en formato aaaa/mm/dd y calcula la edad en números enteros
	//echo $fecha_nac;
	$dia=date("j");
	$mes=date("n");
	$anno=date("Y");
	
	//descomponer fecha de nacimiento
	$dia_nac=substr($fecha_nac, 8, 2);
	$mes_nac=substr($fecha_nac, 5, 2);
	$anno_nac=substr($fecha_nac, 0, 4);
	
	
	if($mes_nac>$mes){
	$calc_edad= $anno-$anno_nac-1;
	}else{
	if($mes==$mes_nac AND $dia_nac>$dia){
	$calc_edad= $anno-$anno_nac-1; 
	}else{
	$calc_edad= $anno-$anno_nac;
	}
	}
	return $calc_edad;
}  

function get_access($idmodulo){
	//print_r($_SESSION);
	if ($idmodulo==11) return 1;
	if (!isset($_SESSION['user']) && $_SESSION['user']<=0){
		echo "<meta http-equiv='refresh' content='0;URL=../index.php' >";
		exit(0);
		
	} 
	if ($_SESSION['rol']==2) return 1;
	/*elseif ($_SESSION['rol']==2) {
		echo "<meta http-equiv='refresh' content='0;URL=../index.php' >";
		exit(0);
		return 0;*/
	else{
		$access=NULL;
		$access = explode("|", $_SESSION['accesos']);
		//print_r($access);
		//echo in_array($idmodulo, $access);
		if (!in_array($idmodulo, $access)){
			//echo "<meta http-equiv='refresh' content='0;URL=../index.php' >";
			return 0;
		}else return 1;
	}	
}

// Fecha en formato dd/mm/yyyy o dd-mm-yyyy retorna la diferencia en dias

function restaFechas($dFecIni, $dFecFin)
{
	
	$dFecIni = str_replace("-","",$dFecIni);
	$dFecIni = str_replace("/","",$dFecIni);
	$dFecFin = str_replace("-","",$dFecFin);
	$dFecFin = str_replace("/","",$dFecFin);
	
	$dFecIni = str_replace(" ","",$dFecIni);
	$dFecFin = str_replace(" ","",$dFecFin);
	
	ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
	ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);
	
	$date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
	$date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);
	
	return round(($date2 - $date1) / (60 * 60 * 24));
}

///////////////////////////////////////////////////FILL COMBO/////////////////////////////////////////////////////

function fill_combo($db=DB, $table, $key, $campo, $select, $campo_bool="", $order=1, $sel_ad=''){
		if (!strcmp($db,"dbcode")) $db = "bdcode";
		
		$rs = new DB_SQL;
		$rs->connect($db);
		$result="";
		$orderby = "";
		if (strlen(trim($campo_bool))) $vigente = "$campo_bool=1";
		else $vigente = "true";
		if ($order) $orderby = "ORDER BY $campo";
		if (strlen(trim($sel_ad))) $vigente .= " AND $sel_ad ";
		
		//if ($_SESSION['user']==1) echo $orderby;
		 
		$rs->get_catalogo("$table", "$key, $campo", $vigente, $orderby);
		while($rs->next_record_obj()){ 
			$sel ="";
			//if (!strcmp("UTF-8", mb_detect_encoding($rs->rs->$campo)))
			//	$rs->rs->$campo = utf8_encode($rs->rs->$campo);
			
			if ($rs->rs->$key==$select) $sel="Selected";
			$result .= "<option value=\"" . $rs->rs->$key . "\" $sel>" . $rs->rs->$campo . "</option>";
		}
		return $result;
	}
function fill_combo2($db=DB, $table, $table2, $key, $campo, $select, $campo_bool="", $order=1, $sel_ad=''){
		
		$rs = new DB_SQL;
		$rs->connect($db);
		$result="";
		$orderby = "";
		if (strlen(trim($campo_bool))) $vigente = "$campo_bool=1";
		else $vigente = "true";
		if ($order) $orderby = "ORDER BY $campo";
		if (strlen(trim($sel_ad))) $vigente .= " AND $sel_ad ";
		 
		$rs->get_catalogo2("$table","$table2", "$key, $campo", $vigente, $orderby);
		while($rs->next_record_obj()){ 
			$sel ="";
			if ($rs->rs->$key==$select) $sel="Selected";
			$result .= "<option value=\"" . $rs->rs->$key . "\" $sel>" . $rs->rs->$campo . "</option>";
		}
		return $result;
	}
function fill_combo3($db=DB, $table, $table2, $key, $campo, $select, $campo_bool="", $order=1, $sel_ad=''){
		
		$rs = new DB_SQL;
		$rs->connect($db);
		$result="";
		$orderby = "";
		if (strlen(trim($campo_bool))) $vigente = "$campo_bool=1";
		else $vigente = "true";
		if ($order) $orderby = "ORDER BY $order";
		if (strlen(trim($sel_ad))) $vigente .= " AND $sel_ad ";
		 
		$rs->get_catalogo2("$table","$table2", "$key, $campo", $vigente, $orderby);
		while($rs->next_record_obj()){ 
			$sel ="";
			if ($rs->rs->$key==$select) $sel="Selected";
			$result .= "<option value=\"" . $rs->rs->$key . "\" $sel>" . $rs->rs->$campo . "</option>";
		}
		return $result;
	}
	function fill_combo_dia($db=DB, $table, $table2, $key, $campo, $select, $campo_bool="", $order=1, $sel_ad=''){
		
		$rs = new DB_SQL;
		$rs->connect($db);
		$result="";
		$orderby = "";
		if (strlen(trim($campo_bool))) $vigente = "$campo_bool=1";
		else $vigente = "true";
		if ($order) $orderby = "ORDER BY $order"; 
		if (strlen(trim($sel_ad))) $vigente .= " AND $sel_ad ";
		 
		$rs->get_catalogo2("$table","$table2", "$key, $campo", $vigente, $orderby);
		while($rs->next_record_obj()){ 
			$sel ="";
			if ($rs->rs->$key==$select) $sel="Selected";
			$result .= "<option value=\"" . $rs->rs->$key . "\" $sel>" . $rs->rs->$campo."_".$rs->rs->$key . "</option>";
		}
		return $result;
	}
	
//////////////////////////////////CREAR MENU/////////////////////////////////////////
function create_menu($modulo){
//if (isset($_SESSION['user'])){
	if (get_access($modulo)){
		if (file_exists("class/class_rh.php")) require_once("class/class_rh.php");
		elseif (file_exists("../class/class_rh.php"))  require_once("../class/class_rh.php");
		elseif (file_exists("../../class/class_rh.php"))  require_once("../../class/class_rh.php");
		
		
		$menu= new rh(DB);
		
		$menu->modulo=$modulo;
		$menu2= new rh(DB);
		$menu2->modulo=$modulo;
		if ($_SESSION['user'] && $_SESSION['rol']){
			$class_menu = "menu";
			$class_sub =  "class='submenu'";
			$class_menuid = "menuList";
			$class_a = "";
			$div_id = "id='menu'";
			$class_if = $class_sub;
			if ($modulo==19 && ($_SESSION['rol']==17 || $_SESSION['rol']==2) ){
				$class_menuid = "nav";
				$class_sub =  "class='sub'";
				//$class_a = "class='sub'";
				$div_id = "";
				$class_if = "";
			}
			
			
			
			$menu_link="<div $div_id>
			<ul id='$class_menuid'>";
			
			$menu_link.="<li><a href='../index.php' tabindex='1' $class_if  >Inicio</a>";   
			$menu->menu();	
			while($menu->next_record_obj()){
				  $show=0;	
			      $menu2->idmenu2 = $menu->rs->idmenu;
				  $menu2->submenu();
				  $class_subx = $class_sub;
				  $imgsubx=""; $imgup="";
				  if ($menu2->total_rows()){
					  $show=1;
					  $class_subx = $class_sub;
				  }else{
					  if ($modulo==19 && ($_SESSION['rol']==17 || $_SESSION['rol']==2) ){
					  	 $class_subx="";
						 $imgsubx="<img src=\"images/t1.png\" />";
						 $imgup = "<img src=\"images/up.gif\" alt=\"\" />";
					  }
				  }
				  
				  
				  $menu_link.="<li><a href='".$menu->rs->link."#' $class_subx tabindex=\"1\">$imgsubx". $menu->rs->men_text ."</a>"; 
				 
			  
				
				  if ($show){
					  $menu_link.=$imgup; 
					  $menu_link.="<ul>";
					   
					  while($menu2->next_record_obj()){
						$menu_link.="<li><a href='".$menu2->rs->link."' >". $menu2->rs->men_text . "</a></li>";
					  }  
					$menu_link.="</ul></li>";
				  }
			}  
			$menu_link.="<li><a href='../index.php?exit=true' $class_if >SALIR</a>"; 
			$menu_link.="</ul>
	 
		  </div>";
	
		echo $menu_link."<br>";
		}
	
		}else{
				if ($modulo<>11) 	echo "<meta http-equiv='refresh' content='0;URL=../index.php' >";
		}
	//}else
//		echo "<meta http-equiv='refresh' content='0;URL=http://integral.cedaf.gob.mx' >";
}

///////////////////////////////////////////////////FILL COMBO SI NO/////////////////////////////////////////////////////

function fill_combo_si_no($variable){
		 $result="";
		 if($variable=='Si'){
					    $result.="<option value=\"0\">Seleccione</option>";
						$result.="<option value=\"Si\" selected >Si</option>";
						$result.="<option value=\"No\">No</option>";
					   }
					elseif($variable=='No'){
						$result.="<option value=\"0\">Seleccione</option>";
						$result.="<option value=\"Si\">Si</option>";
						$result.="<option value=\"No\"selected>No</option>";
						}
					else{
						$result.="<option value=\"0\">Seleccione</option>";
						$result.="<option value=\"Si\" >Si</option>";
						$result.="<option value=\"No\">No</option>";
						}	
		return $result;
	}
	
///////////////////////////////////////////////////FILL COMBO SI NO2/////////////////////////////////////////////////////

function fill_combo_si_no2($variable){
		 $result="";
		 if($variable=='1'){
					    $result.="<option value=\"0\">Seleccione</option>";
						$result.="<option value=\"1\" selected >Si</option>";
						$result.="<option value=\"2\">No</option>";
					   }
					elseif($variable=='2'){
						$result.="<option value=\"0\">Seleccione</option>";
						$result.="<option value=\"1\">Si</option>";
						$result.="<option value=\"2\"selected>No</option>";
						}
					else{
						$result.="<option value=\"0\">Seleccione</option>";
						$result.="<option value=\"1\" >Si</option>";
						$result.="<option value=\"2\">No</option>";
						}	
		return $result;
	}	

///////////////////////////////////////////////////OBTENER EL MES DE UN ARRAY/////////////////////////////////////////////////////
function get_mes($idmes){
		$array = array(0 => 'Seleccione', 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 
		          7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre');
		foreach($array as $dato=>$significado) {
	                    if($idmes == $dato){
						   return $significado;  
						}
		}
		      
}

function fill_combo_mes($idmes){
	$result="";
	$array = array(0 => 'Seleccione', 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 
		          7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre');
	foreach($array as $dato=>$significado) {
	        if($idmes == $dato){
			$result .= "<option value=\"".$dato."\" selected=\"selected\">".$significado."</option>";
			}
			else{
			$result .= "<option value=\"".$dato."\" >".$significado."</option>";
			}
 } 
 return $result;
}


function get_opciones($asistencia){
	    $resultado="";
		switch( $asistencia ){						
		
		case 1: $resultado = "BIEN";
				break;
		case 2: $resultado = "REGULAR";
				break;
		case 3: $resultado = "BAJA";
				break;																				
		
        }
		
		return $resultado;	
	}
	
	////Funcion para imprimir el estado civil de una persona ////
	function get_edo_civil($edo_civil){
	    $resultado="";
		switch( $edo_civil ){						
		
		case 1: $resultado = "Soltero";
				break;
		case 2: $resultado = "Casado";
				break;
		case 3: $resultado = "Divorciado";
				break;
		case 4: $resultado = "Viudo";
				break;																						
		
        }
		
		return $resultado;	
	}


function create_menu_boot($modulo){
//if (isset($_SESSION['user'])){
	if (get_access($modulo)){
		if (file_exists("class/class_rh.php")) require_once("class/class_rh.php");
		elseif (file_exists("../class/class_rh.php"))  require_once("../class/class_rh.php");
		elseif (file_exists("../../class/class_rh.php"))  require_once("../../class/class_rh.php");
		
		
		$menu= new rh(DB);
		
		$menu->modulo=$modulo;
		$menu2= new rh(DB);
		$menu2->modulo=$modulo;
		if ($_SESSION['user'] && $_SESSION['rol']){
			$class_menu = "menu";
			$class_sub =  "class='dropdown'";
			$class_sub2 = "class='dropdown-toggle' data-toggle='dropdown' ";
			$class_sub3 = "<b class='caret'></b>";
			$class_menuid = "menuList";
			$class_a = "";
			//$div_id = "id='menu'";
			$div_id = "id='menuBoot'";
			$class_if = $class_sub;
			if ($modulo==19 && ($_SESSION['rol']==17 || $_SESSION['rol']==2) ){
				$class_menuid = "nav";
				$class_sub =  "class='sub'";
				//$class_a = "class='sub'";
				$div_id = "";
				$class_if = "";
			}
			
          
			$menu_link="<nav $div_id class='navbar navbar-default navbar-static-top' role='navigation' style='font-size: 84%; font-weight: bold;'>
			<div class='navbar-header' >
			<button type='button' class='navbar-toggle' data-toggle='collapse'
            data-target='.navbar-ex1-collapse'>
      			<span class='sr-only'>Desplegar navegación</span>
      			<span class='icon-bar'></span>
      			<span class='icon-bar'></span>
      			<span class='icon-bar'></span>
    		</button>
    		<a class='navbar-brand' href='../index.php'></a>
  			</div>
			<div class='collapse navbar-collapse navbar-ex1-collapse'>
			<ul id='$class_menuid' class='nav nav-pills'>
			   <li ><a href='../index.php' >Inicio</a>";
			
			//$menu_link.="<li><a href='../index.php' tabindex='1' $class_if  >Inicio</a>";   
			$menu->menu();	
			while($menu->next_record_obj()){
				$class_sub =  "class='dropdown'";
			$class_sub2 = "class='dropdown-toggle' data-toggle='dropdown' ";
			$class_sub3 = "<b class='caret'></b>";
				  $show=0;	
			      $menu2->idmenu2 = $menu->rs->idmenu;
				  $menu2->submenu();
				  $class_subx = $class_sub;
				  $imgsubx=""; $imgup="";
				  if ($menu2->total_rows()){
					  $show=1;
					  $class_subx = $class_sub;
				  }else{
					  if ($modulo==19 && ($_SESSION['rol']==17 || $_SESSION['rol']==2) ){
					  	 $class_subx="";
						 $imgsubx="<img src=\"images/t1.png\" />";
						 $imgup = "<img src=\"images/up.gif\" alt=\"\" />";
					  }
					  else{
						   $class_subx="";
						   $class_sub2="";
						   $class_sub3 = "";
						   //$imgsubx="<img src=\"images/t1.png\" />";
						   //$imgup = "<img src=\"images/up.gif\" alt=\"\" />";

						  }
				  }
				  
				  
				  $menu_link.="<li $class_subx><a href='".$menu->rs->link."#' $class_sub2  >$imgsubx". $menu->rs->men_text ." ".$class_sub3."</a>"; 
				 
			  
				
				  if ($show){
					  $menu_link.=$imgup; 
					  $menu_link.="<ul class='dropdown-menu'>";
					   
					  while($menu2->next_record_obj()){
						$menu_link.="<li><a href='".$menu2->rs->link."' >". $menu2->rs->men_text . "</a></li>";
					  }  
					$menu_link.="</ul></li>";
				  }
			}  
			//$menu_link.="<li><a href='../index.php?exit=true' $class_if >SALIR</a>"; 
			$menu_link.="<li><a href='../index.php?exit=true'  >Salir</a>"; 
			$menu_link.="</ul>
	      </div> 
		  </nav>";
	
		//echo $menu_link."<br>";
		echo $menu_link;
		}
	
		}else{
				if ($modulo<>11) 	echo "<meta http-equiv='refresh' content='0;URL=../index.php' >";
		}
	//}else
//		echo "<meta http-equiv='refresh' content='0;URL=http://integral.cedaf.gob.mx' >";
}	
	
	
	
?>
