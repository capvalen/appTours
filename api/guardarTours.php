<?php 

include ("conectkarl.php");
include __DIR__ . '/slug.php';
$_POST = json_decode(file_get_contents('php://input'),true);
//var_dump($_POST['tour']); die();

( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';

if(isset($_POST['idPais'])) $idPais = $_POST['idPais'];
else $idPais = 140;

// ===== La url se genera desde el nombre, con las mismas reglas que al actualizar =====
// Si ya existe la misma url (con visible = 1) se le agrega "-N", donde N es la
// cantidad de registros repetidos que ya hay
$tour = (isset($_POST['tour']) && is_array($_POST['tour'])) ? $_POST['tour'] : [];

$urlGenerada = generarSlug($tour['nombre'] ?? '');
if ($urlGenerada !== '') {
	$urlGenerada    = urlUnica($db, $urlGenerada, 0, true);
	$tour['url']    = $urlGenerada;
	$tour['queUrl'] = $urlGenerada;
	$_POST['tour']  = $tour;
}

$sql =$db->prepare("INSERT INTO `tours`(`contenido`, `visible`, `url`, `pais`) VALUES (?, 0, ?, ?);");
$resp = $sql->execute([ json_encode($tour, JSON_UNESCAPED_UNICODE), $tour['url'] ?? '', $idPais ]);


if($resp){

	$idTour = $db->lastInsertId();
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