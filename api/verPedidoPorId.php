<?php 
include ("conectkarl.php");

$filas = [];

$sql= $db->prepare("SELECT p.* FROM `pedidos` p where p.id = ?;"); // inner join tours t on t.id = p.idTour 
if( $sql->execute( [ $_POST['id'] ] )){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);