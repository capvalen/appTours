<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
include ("conectkarl.php");

$filas = [];
//SELECT * FROM `tours` where id between 134 and 146 order by RAND() DESC limit 12
$sql= $db->query("SELECT * FROM `tours` where visible=1 and activo=1 order by RAND() DESC LIMIT 12;"); //
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		$stmt = $db->prepare("SELECT d.*, p.imagen  FROM descuentos d
		inner join promociones p on p.id = d.promocion_id
		WHERE id_tour = ? AND d.activo = 1 AND CURDATE() BETWEEN fecha_inicio AND fecha_fin LIMIT 1;");
		$stmt->execute([$row['id']]);
		$descuento = $stmt->fetch(PDO::FETCH_ASSOC);
		$row['descuento'] = $descuento ?: null;
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	print_r($sql->errorinfo());
}

echo json_encode($filas);