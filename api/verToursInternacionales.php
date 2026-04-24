<?php 
include ("conectkarl.php");

$filas = [];

$sql= $db->query("SELECT t.*, p.nombre as nomPais FROM `tours` t inner join paises p on t.pais = p.id where t.tipo=1 and t.activo=1 and t.pais <> 140 order by t.id DESC;");
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