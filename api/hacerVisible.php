<?php 
include ("conectkarl.php");
( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';
$_POST = json_decode(file_get_contents('php://input'),true);

($_POST['visible']) ? $estado=1 : $estado=0;
$sql =$db->prepare("UPDATE `tours` SET `visible` = ? WHERE `id` = ?; ");
$resp = $sql->execute([ $estado, $_POST['id'] ]);

if($resp){
	echo 'ok';
}else{
	echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

?>