<?php 
include ("conectkarl.php");
$_POST['jsonCliente'] = [];
$_POST['jsonProductos'] = [];

$sql= $db->prepare("INSERT INTO `pedidos`(`idTour`, `idEstado`, `nacionalidad`, `adultos`, `menores`, 
`precAdulto`, `precMenor`, `total`, `moneda`, `tipoDocumento`, 
`dni`, `nombre`, `apellido`, `correo`, `celular`, 
`ciudad`, `direccion`, `titulo`, `separado`, tipoComprobante,
nRuc, nRazon, nDireccion) VALUES
(?, ?, ?, ?, ?,
 ?, ?, ?, ?, ?,
 ?, ?, ?, ?, ?,
 ?, ?, ?, ?, ?,
 ?, ?, ?)");

$resp = $sql->execute([ $_POST['id'], 1, $_POST['nacionalidad'], $_POST['adultos'], $_POST['kids'],
	$_POST['adultoNormal'], $_POST['menorNormal'], $_POST['total'], $_POST['moneda'], $_POST['tipoDocumento'],
	$_POST['documento'], $_POST['nombres'], $_POST['apellidos'], $_POST['correo'], $_POST['celular'],
	$_POST['ciudad'], $_POST['direccion'], $_POST['titulo'], $_POST['empieza'], $_POST['tipoComprobante'],
	$_POST['nRuc'], $_POST['nRazon'], $_POST['nDireccion']
 ]);

 if($resp){
	 //echo 'ok';
	 $idPedido = $db->lastInsertId();
	 /* Se empieza a guardar en grancias.php
	 if(strlen($_POST['documento'])>=8){
		$_POST['jsonCliente'][0]['dni'] = $_POST['documento'];
		$_POST['jsonCliente'][0]['cliRazonSocial'] = $_POST['apellidos'].' '. $_POST['nombres'];
		$_POST['jsonCliente'][0]['direccion'] = $_POST['direccion'];
		$_POST['emitir'] = '3';
		$_POST['queSerie'] = 'BE01';
		$_POST['razonSocial'] = $_POST['jsonCliente'][0]['cliRazonSocial'];
		$_POST['dniRUC'] = $_POST['jsonCliente'][0]['dni'];
		$_POST['cliDireccion'] = $_POST['direccion'];
		$_POST['jsonCliente'][0]['contado'] = 1;
		$_POST['jsonCliente'][0]['adelanto'] = 0;

		//Producto:
		$_POST['jsonProductos'][0]['afecto'] = 1;
		$_POST['jsonProductos'][0]['cantidad'] = 1;
		$_POST['jsonProductos'][0]['unidadSunat'] = 'NIU';
		$_POST['jsonProductos'][0]['idProd'] = 1;
		$_POST['jsonProductos'][0]['descripcionProducto'] = $_POST['titulo'];
		$_POST['jsonProductos'][0]['precioProducto'] = $_POST['total'];
		$_POST['jsonProductos'][0]['subtotal'] = $_POST['total'];
		
	 }
	 ob_start();
	 include('../facturador/php/insertarBoleta.php');
	 ob_end_clean(); */
	
	/*  foreach($_POST['tour']['actividades'] as $valor){
		 $sqlActiv = $db->prepare("INSERT INTO `tourActividades`(`idTour`, `idActividad`) VALUES (?, ?);");
		 $respActiv = $sqlActiv->execute([ $idTour, $valor ]);
	 }
	 
	 foreach($_POST['tour']['categorias'] as $campo){
		 $sqlCateg = $db->prepare("INSERT INTO `tourCategorias`(`idTour`, `idCategoria`) VALUES (?, ?);");
		 $respCateg = $sqlCateg->execute([ $idTour, $campo ]);
	 } */
	 echo $idPedido;

	}else{
	echo $sql->debugDumpParams();
	echo 'error';
}

?>