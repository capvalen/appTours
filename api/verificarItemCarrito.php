<?php 
include ("conectkarl.php");

$filas = [];
$entrega = [];
$descuento = [];

$adultos =0;
$menores = 0;
$total=0;
$hora ='';
$nombre ='';
$adultNormal =0;
$kidNormal=0;

$sql= $db->prepare("SELECT * FROM `tours` where id= ? order by tipo asc, id DESC limit 4;");
if( $sql->execute([$_POST['id']])){
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	$filas = $row;
	$caso = json_encode($filas);
	$tempo = json_decode($caso,true);
	$contenido = json_decode($tempo['contenido'], true);
	//var_dump($contenido['peruanos']);
	//var_dump($contenido);
	if($_POST['nacionalidad'] == '159' ){ 
		//Peruano
		$adultos = floatval($contenido['peruanos']['adultos']) * intval($_POST['adultos']);
		$menores = floatval($contenido['peruanos']['kids']) * intval($_POST['kids']);
		$adultNormal = floatval($contenido['peruanos']['adultos']);
		$kidNormal = floatval($contenido['peruanos']['kids']);
	}else{
		//extranjeros
		$adultos = floatval($contenido['extranjeros']['adultos']) * intval($_POST['adultos']);
		$menores = floatval($contenido['extranjeros']['kids']) * intval($_POST['kids']);
		$adultNormal = floatval($contenido['extranjeros']['adultos']);
		$kidNormal = floatval($contenido['extranjeros']['kids']);
	}
	$nombre = $contenido['nombre'];
	$fotos = $contenido['fotos'];
	$hora = $_POST['horario'] ==-1 ? $contenido['hora'] : $contenido['hora2'];
	$total = $adultos + $menores;
	$url = $contenido['url'];

	// Buscar descuento activo para este tour
	$sqlDesc = $db->prepare("SELECT id, nombre_descuento, tipo_descuento, valor_descuento FROM `descuentos` WHERE `id_tour` = ? AND curdate() between fecha_inicio and fecha_fin AND `activo` = 1 limit 1;");
	$sqlDesc->execute([$_POST['id']]);
	$descuento = $sqlDesc->fetch(PDO::FETCH_ASSOC);

	/* while(  ){
		
	} */
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode( array(
	'nombre'=>$nombre, 
	'adultos'=> $adultos, 
	'menores' => $menores, 
	'total'=>$total, 
	'hora'=> $hora, 
	'adultoNormal'=> $adultNormal, 
	'menorNormal'=>$kidNormal, 
	'idProducto'=>$_POST['id'], 
	'fotos'=>$fotos, 
	'cantAdultos' => $_POST['adultos'], 
	'cantKids' => $_POST['kids'], 
	'url'=>$url,
	'descuento' => $descuento
));