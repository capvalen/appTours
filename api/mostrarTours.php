<?php 
include ("conectkarl.php");

$filas = [];

$sql= $db->query("SELECT * FROM `tours` where visible=1 and activo=1 order by tipo asc, id DESC limit 12;");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);