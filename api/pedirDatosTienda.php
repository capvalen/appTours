<?php 
include ("conectkarl.php");

$actividades = [];
$categorias = [];

$sqlActividades = $db->query("SELECT * from actividades where activo = 1; ");
if($sqlActividades ->execute()){
	while($rowActividades = $sqlActividades->fetch(PDO::FETCH_ASSOC)){
		$actividades[] = $rowActividades;
	}
}

$sqlCategorias = $db->query("SELECT * from categorias where activo = 1; ");
if($sqlCategorias ->execute()){
	while($rowCategorias = $sqlCategorias->fetch(PDO::FETCH_ASSOC)){
		$categorias[] = $rowCategorias;
	}
}

echo json_encode( array($actividades, $categorias) );