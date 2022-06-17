<?php 
include ("conectkarl.php");

$filas ='';
$sql = $db->query("SELECT * from `configuraciones` WHERE `configuraciones`.`id` = 1;");
if($sql->execute()){
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$filas = $row;
	}
	echo $filas['contenido'];
} else{
	echo 'error';
}