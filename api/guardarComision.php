<?php 
include ("conectkarl.php");

$sql= $db->prepare("UPDATE `configuraciones` SET `contenido` = ? WHERE `configuraciones`.`id` = 3;");

$resp = $sql->execute([ $_POST['comision'] ]);

 if($resp){
	 echo 'ok';
}else{
	echo $sql->debugDumpParams();
	echo 'error';
}

?>