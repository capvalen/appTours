<?php 
include ("conectkarl.php");

$sql = $db->query("UPDATE `configuraciones` SET `contenido` = '{$_POST['contenido']}' WHERE `configuraciones`.`id` = 4;");
if($sql->execute()){
	echo 'ok';
} else{
	echo 'error';
}