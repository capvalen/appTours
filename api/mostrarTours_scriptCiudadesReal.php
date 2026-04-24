<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
include ("conectkarl.php");

$filas = [];

$sql= $db->query("SELECT * FROM `tours` where visible=1 and activo=1 
and upper( JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.destino'))) COLLATE utf8mb4_unicode_ci like upper('%{$_POST['texto']}%') 
order by registro desc;");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);
