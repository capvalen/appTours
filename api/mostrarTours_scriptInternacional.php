<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
include ("conectkarl.php");

$filas = [];

if( $_POST['pais']>0 )
    $sql= $db->query("SELECT * FROM `tours` where visible=1 and activo=1 
    and pais= '{$_POST['pais']}'
    order by registro desc ;"); //limit 30
else if( isset($_POST['texto']) )
    $sql= $db->query("SELECT * FROM `tours` where visible=1 and activo=1 
    and lower( JSON_EXTRACT(contenido, '$.destino' COLLATE utf8_general_ci)) LIKE '%{$_POST['texto']}%' COLLATE utf8_general_ci
    order by registro desc ;"); //limit 30

if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);