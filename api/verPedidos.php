<?php 
include ("conectkarl.php");

if($_POST['id']=='todos'){
	$filtro = "p.activo = 1";
}else{
	$filtro = "p.id =" + $_POST['id'];
}
$filas = [];

$sql= $db->query("SELECT p.*, e.estado, t.url FROM `pedidos` p
inner join estados e on e.id = p.idEstado
inner join tours t on t.id = p.idTour
where " . $filtro ." and idEstado = 2 and p.activo = 1
order by fecha desc
limit 50;");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);