<?php 
include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);

switch($_POST['pedir']){
	case 'listar': listar($db); break;
	case 'borrar': borrar($db); break;
	case 'crear': crear($db); break;
}

function listar($db){
	$filas = [];
	$sql = $db->query("SELECT * FROM `alojamientos` where activo = 1 order by alojamiento asc;");
	if($sql->execute()){
		while($row = $sql->fetch(PDO::FETCH_ASSOC))
			$filas[] = $row;
		echo json_encode($filas);
	}else echo "[]";
}
function crear($db){
	$sql="INSERT INTO `alojamientos`(`alojamiento`) VALUES ('{$_POST['alojamiento']}');;";
	if($db->query($sql)){
		echo 'ok';
	}else{ echo 'error';}
}
function borrar($db){
	$sql="UPDATE `alojamientos` SET `activo` = 0 WHERE `id` = {$_POST['id']};";
	if($db->query($sql)){
		echo 'ok';
	}else{ echo 'error';}
}