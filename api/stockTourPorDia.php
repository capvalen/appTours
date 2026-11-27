<?php
include ("conectkarl.php");
( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' ) ? die() : '';

header('Content-Type: application/json; charset=utf-8');

$datos = json_decode(file_get_contents('php://input'), true);
if(!is_array($datos)) $datos = [];

$idTour = $datos['id'] ?? $_POST['id'] ?? $_GET['id'] ?? 0;
$fecha  = $datos['fecha'] ?? $_POST['fecha'] ?? $_GET['fecha'] ?? '';

if($fecha == '') $fecha = date('Y-m-d');

$stock = 0;

if($idTour){
	// Cupos totales del tour (guardados dentro del JSON de `contenido`)
	$sqlTour = $db->prepare("SELECT `contenido` FROM `tours` WHERE `id` = ? LIMIT 1");
	$sqlTour->execute([ $idTour ]);
	$contenidoTour = $sqlTour->fetchColumn();
	$contenido = ($contenidoTour !== false) ? (json_decode($contenidoTour, true) ?? []) : [];
	$cupos = intval($contenido['cupos'] ?? 0);

	// Cupos ya comprados ese día: suma de adultos y menores de los pedidos del tour
	$sqlComprados = $db->prepare("SELECT COALESCE(SUM(adultos + menores), 0) FROM `pedidos`
		WHERE `idTour` = ? AND DATE(`fecha`) = ? AND `activo` = 1");
	$sqlComprados->execute([ $idTour, $fecha ]);
	$comprados = intval($sqlComprados->fetchColumn());

	$stock = $cupos - $comprados;
}

echo json_encode( array("stock" => (int)$stock) );
