<?php 
include ("conectkarl.php");

$filas = [];

$sql = $db->query("SELECT * FROM `tours` WHERE tipo = 1 AND activo = 1 AND pais = 140 ORDER BY id DESC;");
if ($sql->execute()) {
	while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
		
		// Obtener descuentos para este tour
		$descuentos = [];
		$sqlDesc = $db->prepare("SELECT d.* FROM `descuentos` d inner join `promociones` p on p.id = d.promocion_id AND p.visible = 1 WHERE d.id_tour = :idTour and d.activo = 1 order by d.fecha_inicio desc; "); //curdate() between fecha_inicio and fecha_fin
		$sqlDesc->bindParam(':idTour', $row['id'], PDO::PARAM_INT);
		$sqlDesc->execute();
		
		while ($desc = $sqlDesc->fetch(PDO::FETCH_ASSOC)) {
			$descuentos[] = $desc;
		}
		
		// Agregar descuentos al tour
		$row['descuentos'] = $descuentos;
		$filas[] = $row;
	}
} else {
	echo $sql->errorInfo()[2];
}

echo json_encode($filas);