<?php 
include ("conectkarl.php");

$sql= $db->prepare("INSERT INTO `pedidos`(`idTour`, `idEstado`, `nacionalidad`, `adultos`, `menores`, 
`precAdulto`, `precMenor`, `total`, `moneda`, `tipoDocumento`, 
`dni`, `nombre`, `apellido`, `correo`, `celular`, 
`ciudad`, `direccion`, `titulo`) VALUES
(?, ?, ?, ?, ?,
 ?, ?, ?, ?, ?,
 ?, ?, ?, ?, ?,
 ?, ?, ?)");

$resp = $sql->execute([ $_POST['id'], 1, $_POST['nacionalidad'], $_POST['adultos'], $_POST['kids'],
	$_POST['adultoNormal'], $_POST['menorNormal'], $_POST['total'], $_POST['moneda'], $_POST['tipoDocumento'],
	$_POST['documento'], $_POST['nombres'], $_POST['apellidos'], $_POST['correo'], $_POST['celular'],
	$_POST['ciudad'], $_POST['direccion'], $_POST['titulo']
 ]);

 if($resp){
	 //echo 'ok';
	 $idTour = $db->lastInsertId();
	
	 foreach($_POST['tour']['actividades'] as $valor){
		 $sqlActiv = $db->prepare("INSERT INTO `tourActividades`(`idTour`, `idActividad`) VALUES (?, ?);");
		 $respActiv = $sqlActiv->execute([ $idTour, $valor ]);
	 }
	 
	 foreach($_POST['tour']['categorias'] as $campo){
		 $sqlCateg = $db->prepare("INSERT INTO `tourCategorias`(`idTour`, `idCategoria`) VALUES (?, ?);");
		 $respCateg = $sqlCateg->execute([ $idTour, $campo ]);
	 }
	 echo $idTour;

	}else{
	echo $sql->debugDumpParams();
	echo 'error';
}

?>