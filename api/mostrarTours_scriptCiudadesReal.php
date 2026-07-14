<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
include ("conectkarl.php");

$filas = [];

// Obtener promociones por alcance
$sqlPromos = $db->query("SELECT * FROM `promociones` WHERE activo = 1 AND CURDATE() BETWEEN inicio AND fin AND alcance != 'individual'");
$promosPorAlcance = [];
if ($sqlPromos) {
	while ($p = $sqlPromos->fetch(PDO::FETCH_ASSOC)) {
		$promosPorAlcance[] = $p;
	}
}

$sql= $db->query("SELECT * FROM `tours` where visible=1 and activo=1 
and upper( JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.destino'))) COLLATE utf8mb4_unicode_ci like upper('{$_POST['texto']}%') 
order by registro desc;");
if( $sql->execute()){
	while( $row = $sql->fetch(PDO::FETCH_ASSOC) ){
		// Buscar descuento individual por id_tour
		$stmt = $db->prepare("SELECT d.*, p.imagen FROM descuentos d
			inner join promociones p on p.id = d.promocion_id
			WHERE id_tour = ? AND d.activo = 1 AND CURDATE() BETWEEN fecha_inicio AND fecha_fin LIMIT 1;");
		$stmt->execute([$row['id']]);
		$descuento = $stmt->fetch(PDO::FETCH_ASSOC);

		// Si no hay individual, buscar por alcance
		if (!$descuento) {
			$contenido = json_decode($row['contenido'], true) ?? [];
			foreach ($promosPorAlcance as $p) {
				$match = false;
				if ($p['alcance'] == 'pais' && $p['pais_id'] == ($row['pais'] ?? 140)) $match = true;
				elseif ($p['alcance'] == 'departamento' && $p['departamento'] == ($contenido['departamento'] ?? '')) $match = true;
				elseif ($p['alcance'] == 'ciudad' && !empty($p['ciudad']) && stripos($contenido['destino'] ?? '', $p['ciudad']) !== false) $match = true;

				if ($match) {
					$descuento = [
						'id' => $p['id'],
						'nombre_descuento' => $p['promocion'],
						'tipo_descuento' => $p['tipo'],
						'valor_descuento' => $p['valor'],
						'imagen' => $p['imagen'] ?? null,
					];
					break;
				}
			}
		}

		$row['descuento'] = $descuento ?: null;
		$filas[] = $row;
	}
}else{
	//echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

echo json_encode($filas);
