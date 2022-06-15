<?php 
include ("conectkarl.php");

$filas = [];

$sql = $db->query("SELECT id, replace(JSON_EXTRACT(contenido, '$.nombre'), '\"', '') AS titulo, replace(JSON_EXTRACT(contenido, '$.fotos[0].nombreRuta'), '\"', '') as foto FROM `tours` where activo = 1 and visible = 1 ORDER BY RAND() limit 4 "); //and tipo = 1
if($sql ->execute()){
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$filas[] = $row;
	}
}
echo json_encode($filas);