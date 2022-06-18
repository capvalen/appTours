<?php 
include ("conectkarl.php");

//var_dump($_POST);
switch ($_POST['comando']) {
	case 'add': agregarCategoria($db); break;
	case 'update': actualizarCategoria($db); break;
	case 'delete': borrarCategoria($db); break;
	
	default:
		# code...
		break;
}

function agregarCategoria($db){
	$sql="INSERT INTO `categorias2`(`concepto`) VALUES ('{$_POST['nombre']}')";
	if($db->query($sql)){
		echo $db->lastInsertId();
	}else{ echo 'error';}
}
function actualizarCategoria($db){
	$sql="UPDATE `categorias2` SET `concepto` = '{$_POST['nombre']}' WHERE `categorias2`.`id` = {$_POST['id']};";
	if($db->query($sql)){
		echo 'ok';
	}else{ echo 'error';}
}
function borrarCategoria($db){
	$sql="UPDATE `categorias2` SET `activo` = 0 WHERE `categorias2`.`id` = {$_POST['id']};";
	if($db->query($sql)){
		echo 'ok';
	}else{ echo 'error';}
}