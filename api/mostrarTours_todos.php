<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
include ("conectkarl.php");

$filas = [];
//SELECT * FROM `tours` where id between 134 and 146 order by RAND() DESC limit 12
$sql= $db->query("SELECT id, url, tipo,
    JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.nombre')) as nombre,    
    JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.peruanos.adultos')) as peruanos_adultos,
    JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.peruanos.kids')) as peruanos_kids,
    JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.extranjeros.adultos')) as extranjeros_adultos,
    JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.extranjeros.kids')) as extranjeros_kids
FROM `tours` 
WHERE activo = 1 AND visible = 1;");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas, true);
