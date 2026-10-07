<?php

/**
 * dashboard.php  ->  Panel de usuario (por ahora solo bienvenida)
 */
require_once __DIR__ . '/php/conexion.php';
require_once __DIR__ . '/php/cifrado.php';

// Proteger: si no hay sesión, al login
if (empty($_SESSION['cuenta_id'])) {
	header('Location: login.php');
	exit;
}

// Si entró con Google y aún no completa sus datos, primero su perfil
if (!empty($_SESSION['perfil_incompleto'])) {
	header('Location: completar_perfil.php');
	exit;
}

$nombres   = $_SESSION['cuenta_nombres']   ?? '';
$apellidos = $_SESSION['cuenta_apellidos'] ?? '';
$correo    = $_SESSION['cuenta_correo']    ?? '';
$nombreCompleto = trim($nombres . ' ' . $apellidos);

// Compras del usuario: el correo se cifra con salt y verPedidos.php lo
// descifra para buscar por el campo `correo`. Todo se resuelve en PHP,
// sin AJAX ni fetch.
$correoCifrado = cifrarCorreo($correo);
define('PANEL_INCLUYE_VERPEDIDOS', true);
require __DIR__ . '/php/verPedidos.php';

// Resumen de compras (para el contador bajo el título)
$totalPedidos = count($pedidos);
$pagadas      = 0;
foreach ($pedidos as $p) {
	if ((int) ($p['idEstado'] ?? 0) === 2) {
		$pagadas++;
	}
}
$sinPagar = $totalPedidos - $pagadas;
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Mi panel - Grupo Euro Andino</title>
	<link rel="icon" href="https://grupoeuroandino.com/wp-content/uploads/2023/07/cropped-Grupo-Euro-Andino-favicon-32x32.png" sizes="32x32" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/estilos.css?v=5">
</head>

<body class="fondo-auth">
	<!-- Barra superior -->
	<nav class="navbar bg-white border-bottom">
		<div class="container">
			<span class="navbar-brand fw-bold mb-0 d-flex align-items-center gap-2">
				<img src="https://grupoeuroandino.com/wp-content/uploads/2020/09/Grupo-Euro-Andino.png"
					alt="Grupo Euro Andino" class="logo-navbar">
				Mi panel - Grupo Euro Andino
			</span>
			<a href="php/cerrar_sesion.php" class="btn btn-primary btn-sm">
				<i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
			</a>
		</div>
	</nav>

	<div class="container py-5">
		<div class="card card-auth w-100 mx-auto">
			<div class="card-body p-4 p-md-5">
				<div class="d-flex align-items-center gap-3 mb-3">
					<div class="icono-auth"><i class="bi bi-hand-thumbs-up"></i></div>
					<h1 class="h4 fw-bold mb-0">¡Bienvenido, <?= htmlspecialchars($nombreCompleto) ?>!</h1>
				</div>

				<p class="lead mb-1">Nos alegra tenerte por aquí.</p>
				<p class="text-muted mb-0">
					Has iniciado sesión con <strong><?= htmlspecialchars($correo) ?></strong>.
				</p>

				<hr class="my-4">

				<!-- Mis compras realizadas -->
				<div class="d-flex align-items-center gap-3 mb-3">
					<div class="icono-auth"><i class="bi bi-bag-check"></i></div>
					<h2 class="h5 fw-bold mb-0">Mis compras realizadas</h2>
				</div>

				<?php if ($errorPedidos === null && $totalPedidos > 0): ?>
					<p class="text-muted mb-3">
						Tienes <strong><?= $totalPedidos ?></strong> <?= $totalPedidos === 1 ? 'pedido' : 'pedidos' ?>.
						<strong><?= $pagadas ?></strong> <?= $pagadas === 1 ? 'pagada' : 'pagadas' ?>,
						<strong><?= $sinPagar ?></strong> sin pagar.
					</p>
				<?php endif; ?>

				<?php if ($errorPedidos !== null): ?>
					<div class="alert alert-danger d-flex align-items-center gap-2 py-2 mb-0" role="alert">
						<i class="bi bi-exclamation-triangle-fill"></i>
						<div><?= htmlspecialchars($errorPedidos) ?></div>
					</div>
				<?php elseif (empty($pedidos)): ?>
					<p class="text-muted mb-0">
						Todavía no tienes compras registradas con
						<strong><?= htmlspecialchars($correo) ?></strong>.
					</p>
				<?php else: ?>
					<div class="table-responsive">
						<table class="table table-hover align-middle tabla-compras mb-0">
							<thead class="table-light">
								<tr>
									<th>N°</th>
									<th>Tour / Paquete</th>
									<th>Fecha</th>
									<th class="text-center">Adultos</th>
									<th class="text-center">Niños</th>
									<th class="text-end">Total</th>
									<th>Estado</th>
									<th class="text-center">Detalles</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($pedidos as $i => $pedido): ?>
									<?php
									$fecha     = $pedido['fecha'] ?? '';
									$fechaTxt  = $fecha ? date('d/m/Y', strtotime($fecha)) : '—';
									$titulo    = $pedido['titulo'] ?? '—';
									$url       = $pedido['url'] ?? '';
									$estaPagada = (int) ($pedido['idEstado'] ?? 0) === 2;

									// Datos que se muestran en el modal de detalle
									// Comprobante: 1 = Factura, 3 = Boleta, otro = Ticket
									$tipoComp  = (int) ($pedido['tipoComprobante'] ?? 0);
									$compTexto = $tipoComp === 1 ? 'Factura' : ($tipoComp === 3 ? 'Boleta' : 'Ticket');

									// Documento: 1 = DNI, 2 = Pasaporte, 3 = Carnet de extranjería
									$tipoDoc   = (int) ($pedido['tipoDocumento'] ?? 0);
									$docTexto  = $tipoDoc === 1 ? 'DNI' : ($tipoDoc === 2 ? 'Pasaporte' : ($tipoDoc === 3 ? 'Carnet de extranjería' : ''));

									// Nacionalidad: 140 = Peruano, otro = Extranjero
									$nacionalidadTexto = (int) ($pedido['nacionalidad'] ?? 0) === 140 ? 'Peruano' : 'Extranjero';
									$detalle = [
										'titulo'           => $titulo,
										'estado'           => $estaPagada ? 'Pagada' : 'Sin pagar',
										'fecha'            => $fecha !== '' ? $fechaTxt : '',
										'inicio'           => !empty($pedido['separado']) ? date('d/m/Y', strtotime($pedido['separado'])) : '',
										'nacionalidad'     => $nacionalidadTexto,
										'documento'        => trim($docTexto . ' ' . ($pedido['dni'] ?? '')),
										'nombre'           => trim(($pedido['nombre'] ?? '') . ' ' . ($pedido['apellido'] ?? '')),
										'correo'           => $pedido['correo'] ?? '',
										'celular'          => $pedido['celular'] ?? '',
										'ciudad'           => $pedido['ciudad'] ?? '',
										'direccion'        => $pedido['direccion'] ?? '',
										'adultos'          => (int) ($pedido['adultos'] ?? 0),
										'menores'          => (int) ($pedido['menores'] ?? 0),
										'precAdulto'       => number_format((float) ($pedido['precAdulto'] ?? 0), 2),
										'precMenor'        => number_format((float) ($pedido['precMenor'] ?? 0), 2),
										'total'            => number_format((float) ($pedido['total'] ?? 0), 2),
										'moneda'           => $pedido['moneda'] ?? 'PEN',
										'descuento'        => (float) ($pedido['descuento'] ?? 0),
										'tipoDescuento'    => $pedido['tipo_descuento'] ?? '',
										'comprobante'      => $compTexto,
										'ruc'              => $pedido['nRuc'] ?? '',
										'razon'            => $pedido['nRazon'] ?? '',
										'direccionFiscal'  => $pedido['nDireccion'] ?? '',
									];
									?>
									<tr>
										<td><?= $i + 1 ?></td>
										<td class="text-capitalize">
											<?php if ($url !== ''): ?>
												<a class="text-decoration-none"
													href="https://grupoeuroandino.com/tours/<?= htmlspecialchars($url) ?>"
													target="_blank" rel="noopener">
													<?= htmlspecialchars(mb_strtolower($titulo)) ?>
													<i class="bi bi-box-arrow-up-right ms-1"></i>
												</a>
											<?php else: ?>
												<?= htmlspecialchars($titulo) ?>
											<?php endif; ?>
										</td>
										<td><?= htmlspecialchars($fechaTxt) ?></td>
										<td class="text-center"><?= (int) ($pedido['adultos'] ?? 0) ?></td>
										<td class="text-center"><?= (int) ($pedido['menores'] ?? 0) ?></td>
										<td class="text-end">S/ <?= number_format((float) ($pedido['total'] ?? 0), 2) ?></td>
										<td>
											<?php if ($estaPagada): ?>
												<span class="badge bg-success">Pagada</span>
											<?php else: ?>
												<span class="badge bg-warning text-dark">Sin pagar</span>
											<?php endif; ?>
										</td>
										<td class="text-center">
											<button type="button"
												class="btn btn-sm btn-outline-primary btn-detalle"
												data-pedido='<?= htmlspecialchars(json_encode($detalle, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8') ?>'>
												<i class="bi bi-eye me-1"></i> Ver
											</button>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<!-- Modal: detalle de la compra (estilo ticket) -->
	<div class="modal fade" id="modalDetalle" tabindex="-1" aria-labelledby="modalDetalleTitulo" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalDetalleTitulo">Detalle de la compra</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div class="modal-body" id="modalDetalleBody"></div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		(function() {
			function esc(v) {
				return String(v === null || v === undefined ? '' : v).replace(/[&<>"']/g, function(c) {
					return {
						'&': '&amp;',
						'<': '&lt;',
						'>': '&gt;',
						'"': '&quot;',
						"'": '&#39;'
					} [c];
				});
			}

			function fila(lbl, val) {
				if (val === null || val === undefined || String(val).trim() === '') return '';
				return '<div class="ticket-fila">' +
					'<span class="lbl">' + esc(lbl) + '</span>' +
					'<span class="val">' + esc(val) + '</span>' +
					'</div>';
			}

			var modalEl = document.getElementById('modalDetalle');
			if (!modalEl) return;
			var modal = new bootstrap.Modal(modalEl);

			document.querySelectorAll('.btn-detalle').forEach(function(boton) {
				boton.addEventListener('click', function() {
					var d;
					try {
						d = JSON.parse(boton.getAttribute('data-pedido'));
					} catch (e) {
						return;
					}

					document.getElementById('modalDetalleTitulo').textContent = d.titulo || 'Detalle de la compra';

					var esPagada = d.estado === 'Pagada';
					var html = '<div class="ticket">';

					// Cabecera del ticket
					html += '<div class="ticket-top">';
					html += '<img src="https://grupoeuroandino.com/wp-content/uploads/2020/09/Grupo-Euro-Andino.png" class="ticket-logo" alt="Grupo Euro Andino">';
					html += '<div class="ticket-empresa">Grupo Euro Andino S.A.C.</div>';
					html += '<div class="ticket-titulo">' + esc(d.titulo) + '</div>';
					html += '<span class="badge ' + (esPagada ? 'bg-success' : 'bg-warning text-dark') + '">' + esc(d.estado) + '</span>';
					html += '</div>';

					// Datos del viajero
					html += '<div class="ticket-seccion">';
					html += fila('Documento', d.documento);
					html += fila('Viajero', d.nombre);
					html += fila('Correo', d.correo);
					html += fila('Celular', d.celular);
					html += fila('Nacionalidad', d.nacionalidad);
					html += fila('Ciudad', d.ciudad);
					html += fila('Dirección', d.direccion);
					html += fila('Fecha de compra', d.fecha);
					html += fila('Fecha de inicio', d.inicio);
					html += '</div>';

					html += '<div class="ticket-corte"></div>';

					// Detalle del pago
					html += '<div class="ticket-seccion">';
					html += '<h6>Detalle del pago</h6>';
					html += fila('Adultos', d.adultos);
					html += fila('Precio por adulto', 'S/ ' + d.precAdulto);

					// Solo se muestran los niños si hay al menos uno
					if (parseInt(d.menores, 10) > 0) {
						html += fila('Niños', d.menores);
						html += fila('Precio por niño', 'S/ ' + d.precMenor);
					}

					if (parseFloat(d.descuento) > 0) {
						var desc = d.tipoDescuento === 'porcentaje' ? d.descuento + '%' : 'S/ ' + d.descuento;
						html += fila('Descuento', desc);
					}
					html += '</div>';

					html += '<div class="ticket-corte"></div>';

					// Total
					html += '<div class="ticket-total">' +
						'<span class="lbl">Total</span>' +
						'<span class="val">S/ ' + esc(d.total) + '</span>' +
						'</div>';

					// Comprobante
					var comprobante = fila('Tipo', d.comprobante) +
						fila('RUC', d.ruc) +
						fila('Razón social', d.razon) +
						fila('Dirección fiscal', d.direccionFiscal);
					if (comprobante !== '') {
						html += '<div class="ticket-seccion mt-2"><h6>Comprobante</h6>' + comprobante + '</div>';
					}

					html += '<div class="ticket-pie">¡Gracias por tu compra!</div>';
					html += '</div>';

					document.getElementById('modalDetalleBody').innerHTML = html;
					modal.show();
				});
			});
		})();
	</script>
</body>

</html>