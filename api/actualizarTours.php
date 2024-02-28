<?php 
include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);

( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';


$lineaActividad ='';
$lineaCategoria ='';

$sql =$db->prepare("UPDATE `tours` SET `contenido` = ?, `url`=? WHERE `id` = ?; ");
$resp = $sql->execute([ json_encode($_POST['tour']),  $_POST['url'], $_POST['id'] ]);


if($resp){

	$idTour = $_POST['id'];

	$sqlReset = $db->prepare("DELETE FROM `tourActividades` WHERE `idTour` = {$idTour}; DELETE FROM `tourCategorias` WHERE `idTour` = {$idTour}; ");
	$sqlReset->execute();
	
	$sqlReset->closeCursor();

	foreach($_POST['tour']['actividades'] as $valor){
		$lineaActividad.="INSERT INTO `tourActividades`(`idTour`, `idActividad`) VALUES ({$idTour}, {$valor});";
	}
	if($lineaActividad<>''){
		$sqlActiv = $db->prepare($lineaActividad);
		$respActiv = $sqlActiv->execute();
		$sqlActiv->closeCursor();
	}

	
	foreach($_POST['tour']['categorias'] as $campo){
		$lineaCategoria .= "INSERT INTO `tourCategorias`(`idTour`, `idCategoria`) VALUES ({$idTour}, {$campo});";
	}
	if($lineaCategoria<>''){
		$sqlCateg = $db->prepare($lineaCategoria);
		$respCateg = $sqlCateg->execute();
		$sqlCateg->closeCursor();
	}

	/* $sqlCateg = $db->prepare("SELECT * FROM `categorias` where nombre = ?;");
	$respCateg = $sqlCateg->execute([ $_POST['categoria'] ]);
	if( $sqlCateg->rowCount()==0 ){
		$sqlInsertCateg = $db->prepare("INSERT INTO `categorias`(`nombre`) VALUES (?);");
		$sqlInsertCateg -> execute([ $_POST['categoria'] ]);
	}

	$sqlActividad = $db->prepare("SELECT * FROM `actividades` where nombre = ?;");
	$respActividad = $sqlActividad->execute([ $_POST['actividad'] ]);
	if( $sqlActividad->rowCount()==0 ){
		$sqlInsertActividad = $db->prepare("INSERT INTO `actividades`(`nombre`) VALUES (?);");
		$sqlInsertActividad -> execute([ $_POST['actividad'] ]);
	} */
	
	echo 'ok';
}else{
	echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

?>