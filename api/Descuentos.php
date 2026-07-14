<?php
include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);

switch($_POST['pedir']){
	case 'borrar': borrar($db); break;
	case 'listar': listar($db); break;
	case 'crear': crear($db); break;
	case 'crearPromocion': crearPromocion($db); break;
	case 'listarPromociones': listarPromociones($db); break;
	case 'borrarPromocion': borrarPromocion($db); break;
	case 'adjuntarFoto': adjuntarFoto($db); break;
}

function borrar($db){
	$sql="UPDATE `descuentos` SET `activo` = 0 WHERE `id` = {$_POST['id']};";
	if($db->query($sql)){
		echo 'ok';
	}else{ echo 'error';}
}

function listar($db){
	$id_tour = $_POST['id_tour'];
	$sql = "SELECT * FROM `descuentos` WHERE `id_tour` = '{$id_tour}' and curdate() between fecha_inicio and fecha_fin AND `activo` = 1;";
	$result = $db->query($sql);

	if($result){
		$descuentos = array();
		while($row = $result->fetch_assoc()){
			$descuentos[] = $row;
		}
		echo json_encode($descuentos);
	}else{
		echo json_encode(['error' => 'No se pudo listar los descuentos']);
	}
}

function crearPromocion($db){
	$nombre_descuento = $_POST['descuento']['promocion'];
	$tipo_descuento = $_POST['descuento']['tipo'];
	$valor_descuento = $_POST['descuento']['valor'];
	$fecha_inicio = $_POST['descuento']['inicio'];
	$fecha_fin = $_POST['descuento']['fin'];
	$alcance = $_POST['descuento']['alcance'] ?? 'individual';
	$pais_id = $_POST['descuento']['pais_id'] ?? 140;
	$departamento = $_POST['descuento']['departamento'] ?? null;
	$ciudad = $_POST['descuento']['ciudad'] ?? null;

	$sql = "INSERT INTO `promociones` (`promocion`, `tipo`, `valor`, `inicio`, `fin`, `activo`, `alcance`, `pais_id`, `departamento`, `ciudad`) VALUES (?, ?, ?, ?, ?, 1, ?, ?, ?, ?)";
	$stmt = $db->prepare($sql);
	$resp = $stmt->execute([$nombre_descuento, $tipo_descuento, $valor_descuento, $fecha_inicio, $fecha_fin, $alcance, $pais_id, $departamento, $ciudad]);
	echo $resp ? 'ok' : 'error';
}

function crear($db){
	$id_tour = $_POST['descuento']['id_tour'];
	$promocion_id = $_POST['descuento']['promocion_id'];
	$nombre_descuento = $_POST['descuento']['nombre_descuento'];
	$tipo_descuento = $_POST['descuento']['tipo_descuento'];
	$valor_descuento = $_POST['descuento']['valor_descuento'];
	$fecha_inicio = $_POST['descuento']['fecha_inicio'];
	$fecha_fin = $_POST['descuento']['fecha_fin'];

	$sql="INSERT INTO `descuentos` (`id_tour`, `promocion_id`, `nombre_descuento`, `tipo_descuento`, `valor_descuento`, `fecha_inicio`, `fecha_fin`, `activo`) VALUES ('{$id_tour}', '{$promocion_id}',  '{$nombre_descuento}', '{$tipo_descuento}', '{$valor_descuento}', '{$fecha_inicio}', '{$fecha_fin}', 1);";
	if($db->query($sql)){
		echo 'ok';
	}else{ echo 'error';}
}

function listarPromociones($db) {
    $sql = "SELECT * FROM `promociones` WHERE `activo` = 1 ORDER BY inicio DESC;";
    $result = $db->query($sql);

    if ($result) {
        $promociones = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($promociones);
    } else {
        echo json_encode(['error' => 'No se pudo listar las promociones']);
    }
}

function adjuntarFoto($db) {
    $sql = "UPDATE `promociones` SET `imagen` = '{$_POST['url']}' WHERE `promociones`.`id` = {$_POST['id']}; ;";
    $result = $db->query($sql);

    if ($result) echo 'ok';
    else 
      echo json_encode(['error' => 'No se pudo adjuntar imágen']);
    
}

function borrarPromocion($db){
	$sql = "UPDATE `promociones` SET `activo` = 0 WHERE `id` = {$_POST['id']};";
	if($db->query($sql)){
		echo 'ok';
	}else{ echo 'error';}
}