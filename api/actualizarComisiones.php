<?php 
include ("conectkarl.php");
//var_dump($_POST);die();


$sql = $db->prepare("UPDATE `configuraciones` SET `contenido` = ? WHERE `configuraciones`.`id` = 2;");
$resp = $sql->execute([ $_POST['dolar'] ]);
$sqlPorc = $db->prepare("UPDATE `configuraciones` SET `contenido` = ? WHERE `configuraciones`.`id` = 3;");
$respPorc = $sqlPorc->execute([ $_POST['comision'] ]);

if($resp && $respPorc) echo 'ok';
else echo 'error';
?>