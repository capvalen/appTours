<?php 
include ("conectkarl.php");

//var_dump($_POST);
switch ($_POST['comando']) {
	case 'add': agregarActividad($db); break;
	case 'update': actualizarActividad($db); break;
	case 'delete': borrarActividad($db); break;
	
	default:
		# code...
		break;
}

function agregarActividad($db){
	$sql="INSERT INTO `actividades2`(`concepto`) VALUES ('{$_POST['nombre']}')";
	if($db->query($sql)){
		echo $db->lastInsertId();
	}else{ echo 'error';}
}
function actualizarActividad($db){
	$sql="UPDATE `actividades2` SET `concepto` = '{$_POST['nombre']}' WHERE `actividades2`.`id` = {$_POST['id']};";
	if($db->query($sql)){
		echo 'ok';
	}else{ echo 'error';}
}
function borrarActividad($db){
	$sql="UPDATE `actividades2` SET `activo` = 0 WHERE `actividades2`.`id` = {$_POST['id']};";
	if($db->query($sql)){
		echo 'ok';
	}else{ echo 'error';}
}