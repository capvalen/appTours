<?php 
include ("conectkarl.php");

$filas = [];
//var_dump($_POST);die();
if($_POST['departamento']=='-1'){ $filtroNuevo="UPPER(JSON_UNQUOTE(JSON_EXTRACT( contenido, '$.nombre' ) )) like UPPER('%".$_POST['texto']."%') ";}
else{
	$filtroNuevo = " JSON_EXTRACT(contenido, '$.departamento') = {$_POST['departamento']}"; //and
}
if($_POST['tipo']!=-1){ $filtroNuevo.= "and tipo = {$_POST['tipo']}"; }

$consulta = "SELECT id, JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.nombre')) as nombre, replace(JSON_EXTRACT(contenido, '$.peruanos.adultos'), '\"', '') as precio, replace(JSON_EXTRACT(contenido, '$.fotos[0].nombreRuta'), '\"', '') as foto FROM `tours` where {$filtroNuevo} and visible=1 and activo = 1 limit 5;";
//echo $consulta;
$sql= $db->query($consulta);
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);