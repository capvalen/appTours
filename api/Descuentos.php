<?php 
include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);

switch($_POST['pedir']){
	case 'borrar': borrar($db); break;
	/* case 'listar': listar($db); break;*/
	case 'crear': crear($db); break; 
}

function borrar($db){
	$sql="UPDATE `descuentos` SET `activo` = 0 WHERE `id` = {$_POST['id']};";
	if($db->query($sql)){
		echo 'ok';
	}else{ echo 'error';}
}

function crear($db){
	$id_tour = $_POST['descuento']['id_tour'];
	$nombre_descuento = $_POST['descuento']['nombre_descuento'];
	$tipo_descuento = $_POST['descuento']['tipo_descuento'];
	$valor_descuento = $_POST['descuento']['valor_descuento'];
	$fecha_inicio = $_POST['descuento']['fecha_inicio'];
	$fecha_fin = $_POST['descuento']['fecha_fin'];

	$sql="INSERT INTO `descuentos` (`id_tour`, `nombre_descuento`, `tipo_descuento`, `valor_descuento`, `fecha_inicio`, `fecha_fin`, `activo`) VALUES ('{$id_tour}', '{$nombre_descuento}', '{$tipo_descuento}', '{$valor_descuento}', '{$fecha_inicio}', '{$fecha_fin}', 1);";
	if($db->query($sql)){
		echo 'ok';
	}else{ echo 'error';}
}