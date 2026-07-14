<?php 
include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);
( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';

$filas = [];
$contenido = [];
$comentarios =[];
$descuentos = [];

$sql= $db->prepare("SELECT * FROM `tours` where activo=1 and id=?;"); //tipo=1 and 
if( $sql->execute( [ $_POST['id'] ] )){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		// Obtener 1 descuento para este tour
		$stmt = $db->prepare("SELECT d.*, p.imagen  FROM descuentos d
		inner join promociones p on p.id = d.promocion_id
		WHERE id_tour = ? AND d.activo = 1 AND CURDATE() BETWEEN fecha_inicio AND fecha_fin LIMIT 1;");
		$stmt->execute([$row['id']]);
		$descuento = $stmt->fetch(PDO::FETCH_ASSOC);

		// Si no hay individual, buscar por alcance
		if (!$descuento) {
			$contenido = json_decode($row['contenido'], true) ?? [];
			$sqlScope = $db->prepare("SELECT id, promocion AS nombre_descuento, tipo AS tipo_descuento, valor AS valor_descuento, imagen
				FROM `promociones` 
				WHERE activo = 1 AND CURDATE() BETWEEN inicio AND fin
				  AND (
					(alcance = 'pais' AND pais_id = ?) OR
					(alcance = 'departamento' AND departamento = ?) OR
					(alcance = 'ciudad' AND ciudad = ?)
				  )
				ORDER BY FIELD(alcance, 'ciudad', 'departamento', 'pais')
				LIMIT 1
			");
			$sqlScope->execute([$row['pais'], $contenido['departamento'] ?? '', $contenido['destino'] ?? '']);
			$rowDescuento = $sqlScope->fetch(PDO::FETCH_ASSOC);
			if ($rowDescuento) {
				$descuento = $rowDescuento;
			}
		}

		$row['descuento'] = $descuento ?: null;
		$contenido = json_decode($row['contenido'], true) ?? [];

		$filas[] = $row;
	}

	
	//$filas[0]['descuentos'] = $descuentos;

	$sqlComentarios = $db->prepare("SELECT * FROM `comentarios` where idTour = ? order by fecha desc limit 5;");
	if( $sqlComentarios->execute([ $_POST['id'] ] )){
		while($rowComentarios = $sqlComentarios->fetch(PDO::FETCH_ASSOC)){
			$comentarios[] = $rowComentarios;
		}
	}
}else{
	echo $sql->debugDumpParams();
	print_r($sql->errorinfo());
}

echo json_encode( array("tour" => $filas[0], "contenido"=>$contenido, "comentarios" => $comentarios) );