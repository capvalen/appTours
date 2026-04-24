<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
include ("conectkarl.php");

$filas = [];
//SELECT * FROM `tours` where id between 134 and 146 order by RAND() DESC limit 12
$sql= $db->query("SELECT * FROM `configuraciones` where id in (2,3)");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);