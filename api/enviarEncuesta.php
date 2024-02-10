<?php 
include ("conectkarl.php");

$sql= $db->prepare("UPDATE `pedidos` SET `calificado` = '1' WHERE `pedidos`.`id` = ?; ");
$resp = $sql->execute([ $_POST['idPedido'] ]);

 if($resp){

	$sqlComentario = $db->prepare("INSERT INTO `comentarios`(`idPedido`, `nombre`, `idTour`, `calificacion`, `comentario`, fecha) VALUES (?, ?, ?, ?, ?, ?)");
	$respComentario = $sqlComentario -> execute([ $_POST['idPedido'], $_POST['nombre'], $_POST['idTour'], $_POST['calificacion'], $_POST['comentario'], $_POST['fecha'] ]);
	if($respComentario){
		//sacamos el promedio
		//$filas = [];
		$sqlPromedio = $db->prepare("SELECT avg(calificacion) as promedio from comentarios where idPedido = ?;");
		$respPromedio = $sqlPromedio->execute([ $_POST['idPedido'] ]);
		$rowPromedio = $sqlPromedio->fetch(PDO::FETCH_ASSOC);
		//while ()
//			$filas[] = $rowPromedio;
		//var_dump($rowPromedio); die();
		$calificacion =  $rowPromedio['promedio'];

		$sqlNumeros = $db->prepare("UPDATE tours SET calificacion = ?, votantes = votantes +1 WHERE id = ?; ");
		$respNumeros = $sqlNumeros->execute([ round($calificacion, 2), $_POST['idTour'] ]);
		echo 'ok';
	}
}else{
	echo $sql->debugDumpParams();
	echo 'error';
}

?>