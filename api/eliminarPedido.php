<?php 
include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);

( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';


$sql =$db->prepare("UPDATE `pedidos` SET `activo` = 0 WHERE `id` = ?; ");
$resp = $sql->execute([ $_POST['id'] ]);


if($resp){
	echo 'ok';
}else{
	echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}
?>