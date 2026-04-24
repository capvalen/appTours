<?php 
include ("conectkarl.php");

$actividades = [];
$categorias = [];

$sql= $db->query("SELECT * FROM `actividades2` where activo = 1;");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$actividades[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

$sqlCategoria= $db->query("SELECT * FROM `categorias2` where activo = 1;");
if( $sqlCategoria->execute()){
	while( $rowCategoria = $sqlCategoria->fetch(PDO::FETCH_ASSOC) ){
		$categorias[] = $rowCategoria;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}


echo json_encode(array($actividades, $categorias));