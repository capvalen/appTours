<?php
include ("conectkarl.php");

$sqlSumaTours = $db->prepare("SELECT count(id) FROM `tours`
where visible = 1 and activo = 1;");
$sqlSumaTours -> execute();
$SumaTours = $sqlSumaTours -> fetchColumn();

$sqlSumaHalf = $db->prepare("SELECT count(id) FROM `tours`
where visible = 1 and activo = 1 and json_extract(contenido, '$.duracion') =1; ");
$sqlSumaHalf -> execute();
$SumaHalf = $sqlSumaHalf -> fetchColumn();

$sqlSumaFull = $db->prepare("SELECT count(id) FROM `tours`
where visible = 1 and activo = 1 and json_extract(contenido, '$.duracion') =2; ");
$sqlSumaFull -> execute();
$SumaFull = $sqlSumaFull -> fetchColumn();

$sqlSumaCategorias = $db->prepare("SELECT idCategoria as id, c.concepto  as nombre FROM `tourCategorias` t inner join categorias2 c on t.idCategoria = c.id 
inner join tours ts on ts.id = t.idTour
where c.activo = 1 and ts.visible=1 and ts.activo=1
group by idCategoria; ");
$sqlSumaCategorias -> execute();
$filasSumaCategorias = $sqlSumaCategorias -> fetchAll(PDO::FETCH_ASSOC);
$SumaCategorias = count($filasSumaCategorias);

$sqlSumaActividades = $db->prepare("SELECT idActividad as id, c.concepto  as nombre FROM `tourActividades` t inner join actividades2 c on t.idActividad = c.id 
inner join tours ts on ts.id = t.idTour
where c.activo = 1 and ts.visible=1 and ts.activo=1
group by idActividad; ");
$sqlSumaActividades -> execute();
$filasSumaActividades = $sqlSumaActividades -> fetchAll(PDO::FETCH_ASSOC);
$SumaActividades = count($filasSumaActividades);

$sqlSumaColegio = $db->prepare("SELECT idCategoria as id, c.concepto  as nombre FROM `tourCategorias` t inner join categorias2 c on t.idCategoria = c.id 
inner join tours ts on ts.id = t.idTour
where c.activo = 1 and ts.visible=1 and ts.activo=1 and c.id = 38; ");
$sqlSumaColegio -> execute();
$filasSumaColegio = $sqlSumaColegio -> fetchAll(PDO::FETCH_ASSOC);
$SumaColegio = count($filasSumaColegio);

$sqlSumaCiudades = $db->prepare("SELECT JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.destino')) as nombre FROM `tours` where activo = 1 and visible=1 group by JSON_EXTRACT(contenido, '$.destino'); ");
$sqlSumaCiudades -> execute();
$filasSumaCiudades = $sqlSumaCiudades -> fetchAll(PDO::FETCH_ASSOC);
$SumaCiudades = count($filasSumaCiudades);

$departamentos = ['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ];
$sqlSumaDepartamentos = $db->prepare("SELECT JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.departamento')) as nombre FROM `tours` where activo = 1 and visible=1 group by JSON_EXTRACT(contenido, '$.departamento'); ");
$sqlSumaDepartamentos -> execute();
$filasSumaDepartamentos = $sqlSumaDepartamentos -> fetchAll(PDO::FETCH_ASSOC);
$SumaDepartamentos = count($filasSumaDepartamentos);

echo json_encode(
	array(
		0=>array(
	'tours' => $SumaTours,
	'half' => $SumaHalf,
	'full' => $SumaFull,
	'categorias' => $SumaCategorias,
	'colegio' => $SumaColegio,
	'actividades' => $SumaActividades,
	'ciudades' => $SumaCiudades,
	'departamentos' => $SumaDepartamentos,
	))
);

/*
74  destinos <- a que se refiere?
*/
?>