<?php 
//---------- Busqueda de pais peru ------------
include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);
( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';

$filas = [];
//var_dump($_POST);die();
if($_POST['ciudad']!=''){ $filtroNuevo=" upper( JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.destino'))) = upper('{$_POST['ciudad']}') ";}
else if($_POST['departamento']==-1){ $filtroNuevo=" contenido like '%nombre%{$_POST['texto']}%' ";}
else{
	$filtroNuevo = " JSON_EXTRACT(contenido, '$.departamento') = '{$_POST['departamento']} '"; //and
}
if($_POST['tipo']!=-1){ $filtroNuevo.= " and tipo = {$_POST['tipo']} "; }
$idPais = $_POST['idPais'] ?? '140';
$filtroNuevo.= " and pais = {$idPais}";

//echo $filtroNuevo;

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