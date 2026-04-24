<?php 
include ("conectkarl.php");

$filas = [];

$sql = $db->query("SELECT id, replace(JSON_EXTRACT(contenido, '$.nombre'), '\"', '') AS titulo, replace(JSON_EXTRACT(contenido, '$.fotos[0].nombreRuta'), '\"', '') as foto,
	JSON_EXTRACT(contenido, '$.departamento') as depa, replace(JSON_EXTRACT(contenido, '$.destino'), '\"', '') as destino,
	replace(JSON_EXTRACT(contenido, '$.oferta'), '\"', '') as oferta, 
	replace(JSON_EXTRACT(contenido, '$.peruanos.adultos'), '\"', '') as precio, replace(JSON_EXTRACT(contenido, '$.duracion'), '\"', '') as duracion,
	JSON_EXTRACT(contenido, '$.duracion') as duracion2, tipo
FROM `tours` 
WHERE activo = 1 and visible = 1
AND JSON_EXTRACT(contenido, '$.departamento') = {$_POST['departamento']}
ORDER BY FIELD(tipo,'{$_POST['tipo']}') desc, FIELD(JSON_EXTRACT(contenido, '$.departamento'), '{$_POST['departamento']}') DESC, RAND() limit 8 "); //and tipo = 1
if($sql ->execute()){
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$filas[] = $row;
	}
}
echo json_encode($filas);