<?php 
include ("conectkarl.php");

$sql = $db->query("UPDATE `configuraciones` SET `contenido` = '{$_POST['panel']}' WHERE `configuraciones`.`id` = 1;");
if($sql->execute()){
	echo 'ok';
} else{
	echo 'error';
}