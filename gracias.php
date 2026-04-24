<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_ALL);

if( $_POST['id']<>-1 ):
	require_once( __DIR__. './../api/conectkarl.php');
	$idPedido = $_POST['id'];
	$tipoDocumento = ['D.N.I.','Pasaporte','Carnet de extranjería'];
	//echo 'el id de pedido ' . $idPedido;


	$sql = $db->prepare("SELECT pe.*, JSON_EXTRACT(t.contenido, '$.duracion') as duracion, JSON_UNQUOTE( JSON_EXTRACT(t.contenido, '$.hora')) as hora, tipo, t.url
	FROM `pedidos` pe inner join tours t on t.id = pe.idTour where pe.id = ?; ");
	if( $sql->execute([ $idPedido ]) ){
		$rowDatos = $sql->fetch(PDO::FETCH_ASSOC);
		$duracionArray = ['Half Day (Medio día)', 'Full Day (1 día)'];

		$hora = DateTime::createFromFormat('H:i', $rowDatos['hora']);
		
		if( is_numeric($rowDatos['duracion']) ){
			$dias['dias'] = $rowDatos['duracion'];
		}else{
			$dias = json_decode($rowDatos['duracion'], true);
		}
		
		if($rowDatos['tipo']==1){ //tour
			if( $dias['dias'] == 1 || $dias['dias']== 2 ){ $duracion = $duracionArray[ $dias['dias']-1 ]; }else{ $duracion = ($dias['dias']-1) .' / 0 noches'; }
			$tipo = 'Tour';
		}else{
			if( $dias['dias'] == 1 || $dias['dias'] == 2 ){ $duracion = $duracionArray[ $dias['dias'] -1 ] . " / ". ($dias['noches'] -1) . "noches"; }else{ $duracion = ($dias['dias']-1) . " / ". ($dias['noches'] -1) . "noches"; }
			$tipo = 'Paquete turístico';
		}
		$_POST['duracion'] = $duracion;
		$_POST['inicio'] = $rowDatos['separado'] . " a las ". $hora->format('g:i a');
		$_POST['tipo'] = $tipo;
		if( $rowDatos['adultos'] >0){ $pasajeros = $rowDatos['adultos']. " adultos"; }
		if( $rowDatos['menores'] >0){ $pasajeros .= ' y '. $rowDatos['menores']. " menores"; }
		$_POST['pasajeros'] = $pasajeros;
		$_POST['tipoDocumento'] = $tipoDocumento[$rowDatos['tipoDocumento']-1];
		$_POST['tipo'] = $_POST['tipoDocumento'];
		

		if($rowDatos['idEstado']==1){ //solo se factura 1 vez
			if($rowDatos['tipoComprobante']=='1'){$serie = 'FE01'; }else{ $serie = 'BE01';}
				$hoy = new DateTime();
		
				$_POST['queSerie'] = $serie;
				$_POST['emitir'] = $rowDatos['tipoComprobante'];
				$_POST['fecha'] = $hoy->format('Y-m-d');
				
				$_POST['empresa'] = array([
					'ruc' => $rowDatos['dni'], 
					'crearArchivo' => 0
				]);
				$_POST['dniRUC'] = $rowDatos['dni'];
				$_POST['razonSocial'] = $rowDatos['apellido'] .' '. $rowDatos['nombre']; //poner razon social en el apellido
				$_POST['cliDireccion'] = $rowDatos['direccion'] .' '. $rowDatos['ciudad'];
				$_POST['celular'] = $rowDatos['celular'];
				$_POST['pais'] = $rowDatos['nacionalidad'];
				$_POST['nacionalidad'] = ($rowDatos['nacionalidad']==1)? 'Peruano' : 'Extranjero';
				$_POST['crearArchivo'] = 0;
		
				$_POST['cliente'] = array([
					'dni' => $rowDatos['dni'],
					'razon' => $rowDatos['apellido'] .' '. $rowDatos['nombre'],
					'direccion' => $rowDatos['direccion'] .' '. $rowDatos['ciudad'],
					'tipo' => $rowDatos['tipoComprobante'],
					'contado' => 1,
					'adelanto' => 0
				]);
				$_POST['jsonCliente'] = $_POST['cliente'];
				$_POST['cabecera'] = array([
					'tipo' => $rowDatos['tipoComprobante'],
					'serie' => $serie,
					'fecha' => $hoy->format('Y-m-d')
				]);
				$_POST['jsonProductos'] = array([
					'id' => 1,
					'idProd' => 1,
					'cantidad' => 1,
					'precio' => $rowDatos['total'],
					'precioProducto' => $rowDatos['total'],
					'afecto' => 1,
					'unidad' => 'UND',
					'unidadSunat' => 'NIU',
					'nombre' => $rowDatos['titulo'],
					'descripcionProducto' => $rowDatos['titulo'],
					'subtotal' => $rowDatos['total'],
					'url' => $rowDatos['url']
				]);
				$_POST['total'] = $rowDatos['total'];
				$_COOKIE['ckidUsuario']= 3;

				setcookie("crearArchivo", 0);
		
				ob_start();
				require __DIR__ . './../facturador/php/insertarBoleta.php';
				$datos = json_decode(ob_get_contents(), true);
				//ob_clean();
				ob_end_clean();
				/* echo ('===== DATA: ====');
				var_dump($datos); //[0]['serie']
				echo ('===== FIN DATA ===='); */
				$comprobanteSerie = $datos[0]['serie'].'-'.$datos[0]['correlativo'];
				//echo $comprobanteSerie;
		
				$sqlUpdate = $auxiliar->prepare("UPDATE `pedidos` SET `idEstado` = '2', fechaPago = CONVERT_TZ(NOW(), '+00:00', '-05:00'), serie='{$comprobanteSerie}' WHERE `pedidos`.`id` = ?;");
				if($sqlUpdate -> execute([ $idPedido ])){
		
				//enviar correo felicitación
				$_POST['comprobante'] = $comprobanteSerie;
				$_POST['serie']= $datos[0]['serie'];
				$_POST['correlativo'] = $datos[0]['correlativo'];
				$_POST['ruc'] = $datos[0]['rucEmisor'];
				$_POST['correo'] = $rowDatos['correo'];
				ob_start();
				require_once(__DIR__. './../api/envio_whastapp.php');
				require_once(__DIR__. './../api/correo.php');
				ob_clean();
		
					?>
				<!DOCTYPE html>
				<html lang="es">
				<head>
					<meta charset="UTF-8">
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<title>Gracias</title>
					<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
				</head>
				<body>
					
					<div class="card m-5">
						<div class="card-body m-5">
							<div class="row">
								<div class="col-4 p-5">
									<img src="https://grupoeuroandino.com/wp-content/uploads/2020/09/Grupo-Euro-Andino.png" classs="img-fluid">
								</div>
								<div class="col-6">
									<h1 class="fs-3">Hola <span class="text-capitalize"><?= strtolower($rowDatos['nombre']); ?></span>, tu compra fue exitosa </h1>
									<p>¡En nombre de GRUPO EURO ANDINO S.A.C. queremos agradecerte inmensamente por la confianza en nuestros servicios! Esperamos que estés súper contento con tu compra, tal como lo estamos nosotros.</p>
									<p>En breve estaremos enviándole su comprobante (Boleta/Factura) al correo electrónico que registró: <?= $rowDatos['correo']; ?></p>
								</div>
							</div>
						</div>
					</div>
					
				</body>
				</html>
				<?php
				$_POST['id'] = -1;
				}else{
					?> <h3>Lo sentimos hubo un error en el servidor, consúltelo con los administradores</h3> <?php
				}
			
		}else{
			?>
			<div class="container">
				<div style="padding: 20px;">
					<h3>Su orden ya fue antendida</h3>
					<p>Se entregó un correo con su pedido</p>
					<p>En caso de no tenerlo, confirme con los administradores con el siguiente código: </p>
					<h3 class="fs-2">Pedido #<?= $rowDatos['id']; ?></h3>
				</div>
			</div>
			<?php
		}
	
	}else{
		$_POST['id'] = -1;
		?> <h3>Lo sentimos hubo un error en el servidor, consúltelo con los administradores</h3> <?php
	}
	$_POST['id'] = -1;


endif;