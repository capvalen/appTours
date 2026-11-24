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

	// Buscar descuento activo para este tour (individual)
	$sqlDesc = $db->prepare("SELECT d.id, d.nombre_descuento, d.tipo_descuento, d.valor_descuento, d.fecha_inicio, d.fecha_fin FROM `descuentos` d INNER JOIN `promociones` p ON p.id = d.promocion_id AND p.visible = 1 WHERE d.`id_tour` = ? AND curdate() between d.fecha_inicio and d.fecha_fin AND d.`activo` = 1 limit 1;");
	$sqlDesc->execute([$_POST['id']]);
	$descuento = $sqlDesc->fetch(PDO::FETCH_ASSOC);

	// Si no hay descuento individual, buscar por alcance (país, departamento, ciudad)
	if (!$descuento) {
		$sqlScope = $db->prepare("
			SELECT id, promocion AS nombre_descuento, tipo AS tipo_descuento, valor AS valor_descuento, alcance,
				inicio AS fecha_inicio, fin AS fecha_fin
			FROM `promociones` 
			WHERE activo = 1 AND visible = 1 AND CURDATE() BETWEEN inicio AND fin
			  AND (
				(alcance = 'pais' AND pais_id = ?) OR
				(alcance = 'departamento' AND departamento = ?) OR
				(alcance = 'ciudad' AND ciudad = ?)
			  )
			ORDER BY FIELD(alcance, 'ciudad', 'departamento', 'pais')
			LIMIT 1
		");
		$sqlScope->execute([$tempo['pais'], $contenido['departamento'], $contenido['destino']]);
		$descuento = $sqlScope->fetch(PDO::FETCH_ASSOC);
	}

	// Solo si hay descuento se adjunta el texto de configuraciones (con las fechas reemplazadas)
	if ($descuento) {
		$descuento['texto'] = textoDescuento($db, $descuento['fecha_inicio'] ?? '', $descuento['fecha_fin'] ?? '');
	}
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

/* Texto configurable del descuento: reemplaza {fecha_inicio} y {fecha_fin}/{fecha_final}
   por las fechas del descuento en formato DD/MM/YYYY. */
function textoDescuento($db, $fechaInicio, $fechaFin){
	$sql = $db->prepare("SELECT `contenido` FROM `configuraciones` WHERE `nombre` = ? LIMIT 1");
	$sql->execute(['texto_descuento']);
	$texto = $sql->fetchColumn();
	if($texto === false || $texto === null || $texto === '') return '';

	$reemplazos = array(
		'{fecha_inicio}' => fechaDdMmAaaa($fechaInicio),
		'{fecha_fin}'    => fechaDdMmAaaa($fechaFin),
		'{fecha_final}'  => fechaDdMmAaaa($fechaFin)
	);
	return str_replace(array_keys($reemplazos), array_values($reemplazos), $texto);
}

function fechaDdMmAaaa($fecha){
	if(empty($fecha)) return '';
	$f = date_create($fecha);
	return $f ? $f->format('d/m/Y') : '';
}