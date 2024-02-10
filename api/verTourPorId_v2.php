<?php 
include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);
( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';

$filas = [];
$comentarios =[];

$sql= $db->prepare("SELECT * FROM `tours` where activo=1 and id=?;"); //tipo=1 and 
if( $sql->execute( [ $_POST['id'] ] )){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}

	$sqlComentarios = $db->prepare("SELECT * FROM `comentarios` where idTour = ? order by fecha desc limit 5;");
	if( $sqlComentarios->execute([ $_POST['id'] ] )){
		while($rowComentarios = $sqlComentarios->fetch(PDO::FETCH_ASSOC)){
			$comentarios[] = $rowComentarios;
		}
	}
}else{
	echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode( array("tour" => $filas[0], "comentarios" => $comentarios) );