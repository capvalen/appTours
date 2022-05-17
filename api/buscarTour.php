<?php 
include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);
( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';

$filas = [];
//var_dump(utf8_decode($_POST['texto']));die();

$sql= $db->query("SELECT * FROM `tours` where contenido like '%nombre%{$_POST['texto']}%' and activo = 1 and tipo =1");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);