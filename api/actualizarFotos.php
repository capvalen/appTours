<?php 
include ("conectkarl.php");
//var_dump($_POST);die();


$sql = $db->prepare("UPDATE `tours` SET `contenido` = JSON_SET(contenido, '$.fotos', '{$_POST['fotos']}') WHERE `id` = {$_POST['id']};");
if($resp = $sql->execute()){
	echo 'ok';
}
else{
	echo $sql->debugDumpParams();
}
