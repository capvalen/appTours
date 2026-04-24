<?php 
include ("conectkarl.php");

$filas = [];

$sql= $db->query("SELECT t.*, p.nombre as nomPais FROM `tours` t inner join paises p on t.pais = p.id where t.tipo=1 and t.activo=1 and t.pais <> 140 order by t.id DESC;");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);