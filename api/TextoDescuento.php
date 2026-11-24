<?php
include ("conectkarl.php");

$datos = json_decode(file_get_contents('php://input'), true);
if(!is_array($datos)) $datos = $_POST;

$nombre = 'texto_descuento';

switch($datos['pedir'] ?? ''){
	case 'obtener': obtener($db, $nombre); break;
	case 'actualizar': actualizar($db, $nombre, $datos['contenido'] ?? ''); break;
	default: echo 'error';
}

function obtener($db, $nombre){
	$sql = $db->prepare("SELECT `contenido` FROM `configuraciones` WHERE `nombre` = ? LIMIT 1");
	$sql->execute([$nombre]);
	$contenido = $sql->fetchColumn();
	echo ($contenido === false) ? '' : $contenido;
}

function actualizar($db, $nombre, $contenido){
	$sql = $db->prepare("UPDATE `configuraciones` SET `contenido` = ? WHERE `nombre` = ?");
	$resp = $sql->execute([$contenido, $nombre]);
	echo $resp ? 'ok' : 'error';
}
