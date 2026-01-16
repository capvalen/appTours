<?php 

include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);
//var_dump($_POST['tour']); die();

( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';

if(isset($_POST['idPais'])) $idPais = $_POST['idPais'];
else $idPais = 140;

$sql =$db->prepare("INSERT INTO `tours`(`contenido`, `visible`, `url`, `pais`) VALUES (?, 0, ?, ?);");
$resp = $sql->execute([ json_encode($_POST['tour'], JSON_UNESCAPED_UNICODE), $_POST['tour']['url'], $idPais ]);


if($resp){
	$idTour = $db->lastInsertId();

	$sqlContar=$db->prepare("SELECT `url` from tours where `url` like concat(?,'%') and activo = 1;");
	$respContar = $sqlContar->execute([ $_POST['tour']['url'] ]);
	$resultadosContar = $sqlContar->fetchAll(PDO::FETCH_ASSOC);
	$repetidos = count($resultadosContar)-1;
	if($repetidos>0){
		$nuevaUrl = $_POST['tour']['url'] .'-'.($repetidos);
		$sqlUrl = $db->prepare("UPDATE `tours` SET url = ? where id = ?;");
		$respUrl = $sqlUrl->execute([ $nuevaUrl, $idTour ]);

		$sql = $db->prepare("UPDATE tours 
			SET contenido = JSON_SET(contenido, '$.url', ?)
			WHERE id = ?");
		$resp = $sql->execute([$nuevaUrl, $idTour]);
	}

	/* $sqlContar = $db->prepare("UPDATE configuraciones SET contenido = contenido +1 where nombre = 'total_tours'; ");
	$sqlContar->execute();

	$valoresValidos = [
		1 => 'total_half',
		2 => 'total_full'
	];
	$duracion = $_POST['tour']['duracion'] ?? null;

	if(isset($duracion)){
		$sqlContar2 = $db->prepare("UPDATE configuraciones SET contenido = contenido +1 where nombre = ?; ");
		$sqlContar2->execute([ $valoresValidos[ $duracion ] ]);
	} */


	
	foreach($_POST['tour']['actividades'] as $valor){
		$sqlActiv = $db->prepare("INSERT INTO `tourActividades`(`idTour`, `idActividad`) VALUES (?, ?);");
		$respActiv = $sqlActiv->execute([ $idTour, $valor ]);
	}
	
	foreach($_POST['tour']['categorias'] as $campo){
		$sqlCateg = $db->prepare("INSERT INTO `tourCategorias`(`idTour`, `idCategoria`) VALUES (?, ?);");
		$respCateg = $sqlCateg->execute([ $idTour, $campo ]);
	}

	/* 
	$sqlActividad = $db->prepare("SELECT * FROM `actividades` where nombre = ?;");
	$respActividad = $sqlActividad->execute([ $_POST['actividad'] ]);
	if( $sqlActividad->rowCount()==0 ){
		$sqlInsertActividad = $db->prepare("INSERT INTO `actividades`(`nombre`) VALUES (?);");
		$sqlInsertActividad -> execute([ $_POST['actividad'] ]);
	}
	*/
	echo 'ok';
}else{
	echo 'error';
}

?>