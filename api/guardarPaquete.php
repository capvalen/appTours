<?php 
include ("conectkarl.php");
include __DIR__ . '/slug.php';
$_POST = json_decode(file_get_contents('php://input'),true);

( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';

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

$sql =$db->prepare("INSERT INTO `tours`(`contenido`, `visible`, url, tipo, pais) VALUES (?, 0, ?, 2, 140);");
$resp = $sql->execute([ json_encode($tour, JSON_UNESCAPED_UNICODE), $tour['url'] ?? '' ]);

if($resp){

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