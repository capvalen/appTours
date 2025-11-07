<?php 
include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);

( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';

$sql =$db->prepare("INSERT INTO `tours`(`contenido`, `visible`, url, tipo, pais) VALUES (?, 0, ?, 2, 140);");
$resp = $sql->execute([ json_encode($_POST['tour'], JSON_UNESCAPED_UNICODE), $_POST['tour']['url'] ]);

if($resp){

	$sqlContar=$db->prepare("SELECT `url` from tours where `url` like concat(?,'%');");
	$respContar = $sqlContar->execute([ $_POST['tour']['url'] ]);
	$resultadosContar = $sqlContar->fetchAll(PDO::FETCH_ASSOC);
	$repetidos = count($resultadosContar);
	if($repetidos>1){
		$nuevaUrl = $_POST['tour']['url'] .'-'.($repetidos+1);
		$sqlUrl = $db->prepare("UPDATE `tours` SET url = ? where id = ?;");
		$respUrl = $sqlUrl->execute([ $nuevaUrl, $idTour ]);

		$sql = $db->prepare("UPDATE tours 
			SET contenido = JSON_SET(contenido, '$.url', ?)
			WHERE id = ?");
		$resp = $sql->execute([$nuevaUrl, $idTour]);
	}

	$sqlCateg = $db->prepare("SELECT * FROM `categorias` where nombre = ?;");
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
	}
	
	echo 'ok';
}else{
	echo 'error';
}

?>