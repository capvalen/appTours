<?php 
include ("conectkarl.php");

$filas =[];
$sql = $db->query("SELECT * from `configuraciones` WHERE 1 ;"); //`configuraciones`.`id` = 1
if($sql->execute()){
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$filas[] = $row;
	}
	//echo json_encode($filas); die();
	echo json_encode(array('lateral' => $filas[0]['contenido'],
	'dolar' => $filas[1]['contenido'], 'comision' => $filas[2]['contenido'],
	'inferior' => $filas[3]['contenido']
	));
} else{
	echo 'error';
}