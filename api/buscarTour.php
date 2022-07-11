<?php 
include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);
( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';

$filas = [];
//var_dump($_POST);die();
if($_POST['departamento']==-1){ $filtroNuevo="contenido like '%nombre%{$_POST['texto']}%'";}
else{
	$filtroNuevo = " JSON_EXTRACT(contenido, '$.departamento') = {$_POST['departamento']}"; //and
}
if($_POST['tipo']!=-1){ $filtroNuevo.= "and tipo = {$_POST['tipo']}"; }

echo "SELECT * FROM `tours` where {$filtroNuevo} and activo = 1; ";
$sql= $db->query("SELECT * FROM `tours` where {$filtroNuevo} and activo = 1; ");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);