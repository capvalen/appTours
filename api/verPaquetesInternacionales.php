<?php 
include ("conectkarl.php");

$filas = [];

$sql= $db->query("SELECT * FROM `tours` where tipo=2 and activo=1 and pais <> 140 order by id DESC;");
if ($sql->execute()) {
	while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
		
		// Obtener descuentos para este tour
		$descuentos = [];
		$sqlDesc = $db->prepare("SELECT * FROM `descuentos` WHERE id_tour = :idTour and activo = 1; "); //curdate() between fecha_inicio and fecha_fin
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