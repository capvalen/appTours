<?php 
include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);

( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';

$sql =$db->prepare("INSERT INTO `tours`(`contenido`, `visible`) VALUES (?, 0);");
$resp = $sql->execute([ json_encode($_POST['tour'], JSON_UNESCAPED_UNICODE) ]);

if($resp){
	echo 'ok';
}else{
	echo 'error';
}

?>