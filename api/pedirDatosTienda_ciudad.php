<?php 
include ("conectkarl.php");

$ciudades = [];
$actividades = [];
$categorias = [];

$sqlCiudades = $db->query("SELECT url, JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.destino')) as nombre FROM `tours` where activo = 1 and visible=1 group by JSON_EXTRACT(contenido, '$.destino')");//SELECT * from actividades where activo = 1;
if($sqlCiudades ->execute()){
	while($rowCiudades = $sqlCiudades->fetch(PDO::FETCH_ASSOC)){
		$ciudades[] = $rowCiudades['nombre'];
	}
}

$sqlActividades = $db->query("SELECT idActividad as id, a.concepto as nombre FROM `tourActividades` t inner join actividades2 a on t.idActividad = a.id where a.activo = 1 group by idActividad");//SELECT * from actividades where activo = 1;
if($sqlActividades ->execute()){
	while($rowActividades = $sqlActividades->fetch(PDO::FETCH_ASSOC)){
		$actividades[] = $rowActividades;
	}
}

$sqlCategorias = $db->query("SELECT idCategoria as id, c.concepto  as nombre FROM `tourCategorias` t inner join categorias2 c on t.idCategoria = c.id where c.activo = 1 group by idCategoria");//SELECT * from categorias where activo = 1;
if($sqlCategorias ->execute()){
	while($rowCategorias = $sqlCategorias->fetch(PDO::FETCH_ASSOC)){
		$categorias[] = $rowCategorias;
	}
}

echo json_encode( array($ciudades, $actividades, $categorias) );