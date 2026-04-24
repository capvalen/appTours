<?php 
include ("conectkarl.php");

$sql= $db->prepare("UPDATE `configuraciones` SET `contenido` = ? WHERE `configuraciones`.`id` = 2;");

$resp = $sql->execute([ $_POST['dolar'] ]);

 if($resp){
	 echo 'ok';
}else{
	echo $sql->debugDumpParams();
	echo 'error';
}

?>