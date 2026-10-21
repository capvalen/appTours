<?php 
include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);

( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';


$lineaActividad ='';
$lineaCategoria ='';

/* ============================================================
 * Slug de la url: las funciones generarSlug() y urlUnica() viven en api/slug.php
 *   "link de vacaciones"      -> "link-de-vacaciones"
 *   'link de "vaciones"?'     -> "link-de-vacaciones"
 *   "Tour (2 días) - ¡Cusco!" -> "tour-2-dias-cusco"
 * ============================================================ */
include __DIR__ . '/slug.php'; // generarSlug() y urlUnica()

// ===== La url se regenera SIEMPRE desde el nombre del tour =====
// Si el nombre llega vacío se respeta la url enviada por el cliente.
// Se pasan: nombre -> id del propio tour (para no contarse a sí mismo)
//           y la url actual (para conservarla si el nombre no cambió)
$idTour      = intval($_POST['id'] ?? 0);
$nombreTour  = $_POST['tour']['nombre'] ?? '';
$urlGenerada = generarSlug($nombreTour);

if ($urlGenerada !== '') {

	// Url que el tour tiene registrada ahora mismo
	$sqlUrlActual = $db->prepare("SELECT `url` FROM `tours` WHERE `id` = ?;");
	$sqlUrlActual->execute([ $idTour ]);
	$urlActual = (string) $sqlUrlActual->fetchColumn();

	$urlGenerada = urlUnica($db, $urlGenerada, $idTour, true, $urlActual);

	$_POST['url']            = $urlGenerada;
	$_POST['tour']['url']    = $urlGenerada;   // queda igual dentro de `contenido`
	$_POST['tour']['queUrl'] = $urlGenerada;   // así el panel muestra la url nueva
}

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
	
	$_POST['id'] = $idTour;
	include __DIR__ . '/verTourPorId_v2.php';
	exit;
}else{
	
	echo json_encode(['ok' => false, 'error' => $sql->debugDumpParams()]);
}

?>