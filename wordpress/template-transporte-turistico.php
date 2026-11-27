<?php
/**
 * Template: /transporte-turistico-desde-peru (vista=transporte-turistico)
 *
 * Formulario de COTIZACIÓN (una sola columna de filas 3 / 2 campos) para
 * transporte / servicios turísticos.
 * Arriba del formulario se muestran el título y la descripción de la página
 * (los mismos textos se usan como meta título / meta descripción).
 * Al pulsar ENVIAR se manda todo a la vez:
 *   - WhatsApp (número según el dominio, igual que Extras/formularioContacto.html)
 *   - Correo a grupoeuroandino@hotmail.com usando wp_mail de WordPress
 *     (el handler AJAX "enviar_cotizacion" vive en tours-infocat-plugin.php)
 *
 * OJO: este archivo debe copiarse a la carpeta del TEMA activo
 * (el plugin lo carga con get_theme_file_path('template-transporte-turistico.php')).
 */

// Metas de la página (patrón wpseo de template-paquetes.php)
$tt_titulo = 'Transporte Turístico en Perú';
$tt_descripcion = 'En Grupo Euro Andino, transformamos tu manera de viajar. Ofrecemos el más exclusivo, puntual y seguro servicio de transporte turístico en Perú, diseñado para agencias de viajes, delegaciones corporativas, grupos de amigos y familias que exigen los más altos estándares de calidad.';

add_filter('wpseo_title', function ($title) use ($tt_titulo) {
	return $tt_titulo . ' - Grupo Euro Andino';
});
add_filter('wpseo_metadesc', function ($desc) use ($tt_descripcion) {
	return $tt_descripcion;
});
add_filter('wpseo_opengraph_title', function ($title) use ($tt_titulo) {
	return $tt_titulo . ' - Grupo Euro Andino';
});
add_filter('wpseo_opengraph_desc', function ($desc) use ($tt_descripcion) {
	return $tt_descripcion;
});

get_header();

// Opciones del select "Cotizar:"
$tt_servicios = [
	'Circuitos Turísticos',
	'Full Days',
	'Giras',
	'Half Days',
	'Otros',
	'Paquetes Turísticos',
	'Paseos Turísticos',
	'Rutas',
	'Tours',
	'Transporte Corporativo',
	'Transporte de Personal',
	'Transporte Ejecutivo',
	'Transporte para Eventos y Bodas',
	'Transporte para Producciones Audiovisuales y Artistas',
	'Traslados: In / Out (Llegada y de retorno)',
	'Viajes de Estudios',
	'Viajes de Excursión',
	'Viajes de Promoción Escolar',
];

// Opciones del select "Vehículo" (se pueden marcar hasta 3, en este orden)
$tt_vehiculos = [
	'Auto (4 pasajeros)',
	'4X4 (4 pasajeros)',
	'Microvan (4 pasajeros)',
	'4X4 (6 pasajeros)',
	'Microvan (7 pasajeros)',
	'Minivan (10 pasajeros)',
	'Minivan (11 pasajeros)',
	'Van (15 pasajeros)',
	'Van (17 pasajeros)',
	'Van (18 pasajeros)',
	'Sprinter (18 pasajeros)',
	'Sprinter (19 pasajeros)',
	'Sprinter (20 pasajeros)',
	'Eurise (20 pasajeros)',
	'Eurise (22 pasajeros)',
	'Eurise (23 pasajeros)',
	'Clave 7 (23 pasajeros)',
	'Clave 7 (24 pasajeros)',
	'Coaster (24 pasajeros)',
	'Coaster (25 pasajeros)',
	'Coaster (26 pasajeros)',
	'Minibus (28 pasajeros)',
	'Minibus (29 pasajeros)',
	'Minibus (30 pasajeros)',
	'Minibus (31 pasajeros)',
	'Minibus (32 pasajeros)',
	'Minibus (33 pasajeros)',
	'Bus (34 de pasajeros a más)',
];
?>

<!-- CSS: solo Bootstrap (ya no se carga headers.php con los estilos de toda la app) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<!-- Flatpickr: selector de hora en formato 12 h (a.m. / p.m.) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">

<style>
	/* Título y descripción de la página */
	.tt-cabecera { padding-bottom: 16px; }
	.tt-titulo {
		font-size: 1.75rem;
		font-weight: 700;
		color: #2b2b2b;
		margin: 24px 0 .75rem;
	}
	.tt-descripcion {
		font-size: .98rem;
		color: #4a4a4a;
		line-height: 1.7;
		margin: 0 0 .9rem;
	}
	.tt-descripcion:last-child { margin-bottom: 0; }
	@media (max-width: 575px) {
		.tt-titulo { font-size: 1.4rem; }
	}

	#cotizacionApp { margin-top: 20px; margin-bottom: 40px; }

	/* Campos */
	#cotizacionApp .campo label,
	#cotizacionApp .campo .campo-etiqueta {
		display: block;
		font-weight: 600;
		font-size: .9rem;
		/* El tema pone label{line-height:1}: se fija igual en los dos para que
		   las etiquetas midan lo mismo y los controles queden a la misma altura */
		line-height: 1;
		margin-bottom: 6px;
		color: #2b2b2b;
	}
	/* Asterisco de campo obligatorio */
	#cotizacionApp .campo label .obligatorio {
		color: #e21212;
		font-weight: 700;
		margin-left: 2px;
	}
	/* Espacio extra debajo de cada fila (además del gutter del row) */
	#cotizacionApp .campo { margin-bottom: .6rem; }
	#cotizacionApp .form-control,
	#cotizacionApp .form-select {
		border: 1px solid rgb(180, 180, 180);
		padding: 8px 12px;
	}
	#cotizacionApp .form-select { padding: 8px 12px; }
	/* El disparador del multiselect es un <button> y el tema pinta los botones de otro
	   color (incluido el :hover): se fuerza el mismo aspecto que los <select> */
	#cotizacionApp .form-select,
	#cotizacionApp .form-select:hover,
	#cotizacionApp .form-select:focus {
		background-color: #fff;
		color: #212529;
	}

	/* Select múltiple de vehículos */
	#cotizacionApp .vehiculo-toggle {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	#cotizacionApp .vehiculo-menu {
		width: 100%;
		max-height: 260px;
		overflow-y: auto;
	}
	#cotizacionApp .campo .vehiculo-item {
		display: flex;
		align-items: center;
		gap: 8px;
		margin: 0;
		padding: 6px 12px;
		font-size: .875rem;
		font-weight: 400;
		cursor: pointer;
	}
	#cotizacionApp .campo .vehiculo-item:hover { background: #f4f4f4; }
	#cotizacionApp .campo .vehiculo-item.bloqueado { opacity: .4; cursor: not-allowed; }
	#cotizacionApp .vehiculo-nota {
		padding: 6px 12px;
		border-top: 1px solid #ededed;
		font-size: .72rem;
		color: #8a8a8a;
	}
	#cotizacionApp .vehiculo-badges {
		display: flex;
		flex-wrap: wrap;
		gap: 4px;
	}
	/* La "x" de cada badge, a la mitad de tamaño */
	#cotizacionApp .vehiculo-badges .btn-close { font-size: .8em; }

	/* Botón a todo el ancho (equivalente BS5 de .btn-block) */
	#cotizacionApp .btn-block { display: block; width: 100%; }

	/* Aviso de uso de datos, encima del botón enviar */
	#cotizacionApp .aviso-datos {
		font-size: .78rem;
		line-height: 1.5;
		color: #7a7a7a;
		margin: 0 0 10px;
	}

	/* Botón enviar (color naranja de la marca) */
	#cotizacionApp .btn-enviar {
		background: #ffa300;
		color: #fff;
		border: 0;
		border-radius: 6px;
		padding: 12px;
		font-weight: 700;
		letter-spacing: .5px;
		text-transform: uppercase;
	}
	#cotizacionApp .btn-enviar:hover { background: #e69500; color: #fff; }
	#cotizacionApp .btn-enviar:disabled { opacity: .6; }

	#cotizacionApp .msg-estado { font-size: .85rem; min-height: 18px; margin-top: 8px; text-align: center; }
	#cotizacionApp .msg-estado.ok { color: #10b916; }
	#cotizacionApp .msg-estado.error { color: #e21212; font-weight: 600; }

	/* Modal de avisos (campos obligatorios / agradecimiento) */
	#cotizacionApp .cotizacion-modal {
		position: fixed;
		inset: 0;
		background: rgba(0, 0, 0, .55);
		display: flex;
		align-items: center;
		justify-content: center;
		padding: 16px;
		z-index: 100000;
	}
	#cotizacionApp .cotizacion-modal.d-none { display: none; }
	#cotizacionApp .cotizacion-modal .modal-caja {
		background: #fff;
		border-radius: 12px;
		width: 100%;
		max-width: 460px;
		overflow: hidden;
		box-shadow: 0 18px 50px rgba(0, 0, 0, .35);
		animation: cotizacionModalIn .25s ease;
	}
	@keyframes cotizacionModalIn {
		from { opacity: 0; transform: translateY(14px) scale(.98); }
		to   { opacity: 1; transform: none; }
	}
	#cotizacionApp .cotizacion-modal .modal-cabecera {
		display: flex;
		align-items: center;
		gap: 10px;
		padding: 16px 20px 0;
		font-weight: 700;
		font-size: 1.1rem;
		color: #2b2b2b;
		background: none;
		border: 0 !important;
	}
	#cotizacionApp .cotizacion-modal .modal-cabecera .alerta-icono {
		font-size: 1.3rem;
		line-height: 1;
	}
	/* La cabecera no lleva color ni borde según el tipo */
	#cotizacionApp .cotizacion-modal .modal-cabecera.error,
	#cotizacionApp .cotizacion-modal .modal-cabecera.ok {
		background: none;
		border: 0 !important;
	}
	#cotizacionApp .cotizacion-modal .modal-cuerpo {
		padding: 18px 20px;
		font-size: .95rem;
		color: #4a4a4a;
		line-height: 1.5;
	}
	#cotizacionApp .cotizacion-modal .modal-cuerpo ul {
		margin: 8px 0 0;
		padding-left: 20px;
		color: #b02a2a;
	}
	#cotizacionApp .cotizacion-modal .modal-cuerpo ul li { margin-bottom: 2px; }
	#cotizacionApp .cotizacion-modal .modal-pie { padding: 0 20px 20px; }
	#cotizacionApp .cotizacion-modal .modal-btn {
		width: 100%;
		border: 0 !important;
		border-radius: 8px;
		padding: 12px;
		color: #fff;
		font-weight: 700;
		letter-spacing: .5px;
		text-transform: uppercase;
	}
	#cotizacionApp .cotizacion-modal .modal-btn.error { background: #dc3545; border: 0 !important; }
	#cotizacionApp .cotizacion-modal .modal-btn.error:hover { background: #b02a37; }
	#cotizacionApp .cotizacion-modal .modal-btn.ok { background: #10b916; border: 0 !important; }
	#cotizacionApp .cotizacion-modal .modal-btn.ok:hover { background: #0d9a12; }
	body.cotizacion-modal-abierto { overflow: hidden; }

</style>

<!-- Título y descripción de la página -->
<div class="container tt-cabecera">
	<h1 class="tt-titulo">Transporte Turístico en Perú</h1>
	<p class="tt-descripcion">En <strong>Grupo Euro Andino</strong>, transformamos tu manera de viajar. Ofrecemos el más exclusivo, puntual y seguro servicio de <strong>transporte turístico en Perú</strong>, diseñado para agencias de viajes, delegaciones corporativas, grupos de amigos y familias que exigen los más altos estándares de calidad.</p>
	<p class="tt-descripcion">Ya sea que necesites traslados desde el aeropuerto, recorridos por la ciudad o excursiones a los destinos más emblemáticos del país, nuestra flota moderna garantiza que cada kilómetro de tu ruta sea una experiencia inolvidable.</p>
</div>

<div class="container" id="cotizacionApp">
	<div class="row g-3 g-xl-4">

		<div class="col-12">
			<div class="row g-3">

				<!-- Cotizar | Vehículo | Seleccionados -->
				<div class="col-12 col-sm-4 campo">
					<label for="cotizar">Cotizar: <span class="obligatorio">*</span></label>
					<select id="cotizar" class="form-select">
						<option value="">Selecciona el servicio</option>
						<?php foreach ($tt_servicios as $tt_servicio): ?>
							<option value="<?= esc_attr($tt_servicio); ?>"><?= esc_html($tt_servicio); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-12 col-sm-4 campo">
					<span class="campo-etiqueta">Vehículo</span>
					<div class="dropdown">
						<button type="button" id="vehiculoBoton" class="form-select vehiculo-toggle text-start" aria-haspopup="true" aria-expanded="false">Selecciona vehículo</button>
						<div class="dropdown-menu vehiculo-menu" id="vehiculoMenu">
							<?php foreach ($tt_vehiculos as $tt_vehiculo): ?>
								<label class="vehiculo-item">
									<input class="form-check-input mt-0" type="checkbox" value="<?= esc_attr($tt_vehiculo); ?>">
									<span><?= esc_html($tt_vehiculo); ?></span>
								</label>
							<?php endforeach; ?>
							<div class="vehiculo-nota">Máximo 3 vehículos</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-4 campo">
					<span class="campo-etiqueta d-none" id="vehiculoEtiqueta">Seleccionados</span>
					<div class="vehiculo-badges" id="vehiculoBadges"></div>
				</div>

				<!-- N° de pasajeros | días | fecha -->
				<div class="col-12 col-sm-4 campo">
					<label for="pasajeros">N° de pasajeros <span class="obligatorio">*</span></label>
					<input type="number" id="pasajeros" class="form-control" min="1" step="1" value="1" inputmode="numeric">
				</div>
				<div class="col-12 col-sm-4 campo">
					<label for="dias">Días <span class="obligatorio">*</span></label>
					<input type="number" id="dias" class="form-control" min="1" step="1" value="1" inputmode="numeric">
				</div>
				<div class="col-12 col-sm-4 campo">
					<label for="fecha">Fecha <span class="obligatorio">*</span></label>
					<input type="date" id="fecha" class="form-control" value="<?= esc_attr(date('Y-m-d')); ?>">
				</div>

				<!-- Ruta / Itinerario | Salida + Retorno -->
				<div class="col-12 col-sm-8 campo">
					<label for="ruta">Ruta / Itinerario: <span class="obligatorio">*</span></label>
					<textarea id="ruta" class="form-control" rows="5" placeholder="Itinerario"></textarea>
				</div>
				<div class="col-12 col-sm-4">
					<div class="campo">
						<label for="salida">Salida <span class="obligatorio">*</span></label>
						<input type="text" id="salida" class="form-control" placeholder="h:mm a.m./p.m." autocomplete="off">
					</div>
					<div class="campo">
						<label for="retorno">Retorno <span class="obligatorio">*</span></label>
						<input type="text" id="retorno" class="form-control" placeholder="h:mm a.m./p.m." autocomplete="off">
					</div>
				</div>

				<!-- Observaciones -->
				<div class="col-12 campo">
					<label for="observaciones">Observaciones</label>
					<textarea id="observaciones" class="form-control" rows="3" placeholder="Indica detalles adicionales o requerimientos especiales (ej. equipaje, paradas, preferencias, asiento para bebé, idioma del guía / conductor o factura / boleta)."></textarea>
				</div>

				<!-- Cliente -->
				<div class="col-12 campo">
					<label for="cliente">Cliente: <span class="obligatorio">*</span></label>
					<input type="text" id="cliente" class="form-control" placeholder="Nombre o empresa" autocomplete="off">
				</div>

				<!-- Celular | Correo electrónico -->
				<div class="col-12 col-sm-6 campo">
					<label for="celular">Celular / WhatsApp <span class="obligatorio">*</span></label>
					<input type="text" id="celular" class="form-control" inputmode="tel" autocomplete="off" placeholder="(+51) 987 654 321">
				</div>
				<div class="col-12 col-sm-6 campo">
					<label for="correo">Correo Electrónico</label>
					<input type="email" id="correo" class="form-control" autocomplete="off" placeholder="tunombre@correo.com">
				</div>

				<!-- Aviso de datos + Enviar (alineados a la tercera columna) -->
				<div class="col-12 col-sm-8 d-none d-sm-block"></div>
				<div class="col-12 col-sm-4 campo">
					<p class="aviso-datos">Al enviar aceptas el uso de tus datos únicamente para enviarte la cotización.</p>
					<button type="button" id="btnEnviar" class="btn-enviar btn-block">Enviar</button>
					<div class="msg-estado" id="msgEstado"></div>
				</div>

			</div>
		</div>

	</div>

	<!-- Modal de avisos (campos obligatorios / agradecimiento) -->
	<div id="modalCotizacion" class="cotizacion-modal d-none" role="dialog" aria-modal="true" aria-hidden="true">
		<div class="modal-caja">
			<div class="modal-cabecera error" id="modalCotizacionCabecera">
				<span class="alerta-icono" id="modalCotizacionIcono">⚠️</span>
				<span id="modalCotizacionTitulo">Todos los campos son obligatorios</span>
			</div>
			<div class="modal-cuerpo" id="modalCotizacionCuerpo"></div>
			<div class="modal-pie">
				<button type="button" class="modal-btn error" id="modalCotizacionBoton">Entendido</button>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>

<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>

<script>
(function () {
	// ===== Celular de WhatsApp según el dominio del servidor =====
	// Copiado tal cual de Extras/formularioContacto.html (el 51 de Perú va siempre delante)
	// OJO: todo va con ";" al final porque el tema/plugins pueden quitar los
	// saltos de línea al concatenar los <script> (sin ";" el JS se rompe).
	const PREFIJO_PAIS = '51';
	const CELULAR_POR_DOMINIO = {
		'grupoeuroandino.com': '947614293',
		'toursjauja.com': '956323084',
	};
	const CELULAR_POR_DEFECTO = '993183661';

	// Dominio sin "www." y en minúsculas (ej: toursjauja.com)
	const DOMINIO = window.location.hostname.toLowerCase().replace(/^www\./, '');
	const celularWhatsApp = PREFIJO_PAIS + (CELULAR_POR_DOMINIO[DOMINIO] || CELULAR_POR_DEFECTO);

	// Endpoint AJAX de WordPress (wp_mail se dispara en tours-infocat-plugin.php)
	const AJAX_URL = <?php echo wp_json_encode(admin_url('admin-ajax.php')); ?>;
	const DESTINO_CORREO = <?php echo wp_json_encode('grupoeuroandino@hotmail.com'); ?>;

	const $ = (id) => document.getElementById(id);
	const cotizar   = $('cotizar');
	const pasajeros = $('pasajeros');
	const dias      = $('dias');
	const fecha     = $('fecha');
	const ruta      = $('ruta');
	const observaciones = $('observaciones');
	const cliente   = $('cliente');
	const salida    = $('salida');
	const retorno   = $('retorno');
	const celular   = $('celular');
	const correo    = $('correo');
	const btn       = $('btnEnviar');
	const estado    = $('msgEstado');

	// ===== Modal de avisos =====
	const modal        = $('modalCotizacion');
	const modalCabeza  = $('modalCotizacionCabecera');
	const modalIcono   = $('modalCotizacionIcono');
	const modalTitulo  = $('modalCotizacionTitulo');
	const modalCuerpo  = $('modalCotizacionCuerpo');
	const modalBoton   = $('modalCotizacionBoton');

	// Abre el modal. tipo: 'error' (rojo) u 'ok' (verde)
	const abrirModal = (tipo, titulo, icono, cuerpoHtml, textoBoton) => {
		modalCabeza.classList.remove('error', 'ok');
		modalCabeza.classList.add(tipo === 'ok' ? 'ok' : 'error');

		modalBoton.classList.remove('error', 'ok');
		modalBoton.classList.add(tipo === 'ok' ? 'ok' : 'error');

		modalIcono.textContent = icono;
		modalTitulo.textContent = titulo;
		modalCuerpo.innerHTML = cuerpoHtml;
		modalBoton.textContent = textoBoton || 'Entendido';

		modal.classList.remove('d-none');
		modal.setAttribute('aria-hidden', 'false');
		document.body.classList.add('cotizacion-modal-abierto');

		modalBoton.focus();
	};

	const cerrarModal = () => {
		modal.classList.add('d-none');
		modal.setAttribute('aria-hidden', 'true');
		document.body.classList.remove('cotizacion-modal-abierto');
	};

	modalBoton.addEventListener('click', cerrarModal);
	// Clic fuera de la caja = cerrar
	modal.addEventListener('click', (e) => { if (e.target === modal) cerrarModal(); });
	// Escape = cerrar
	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape' && !modal.classList.contains('d-none')) cerrarModal();
	});

	// Aviso de campos obligatorios en modal
	const mostrarAlertaObligatorios = (nombres) => {
		abrirModal(
			'error',
			'Todos los campos son obligatorios',
			'⚠️',
			'<p style="margin:0;">Completa los siguientes campos para continuar:</p>' +
			'<ul>' + nombres.map((n) => '<li>' + n + '</li>').join('') + '</ul>',
			'Entendido'
		);
	};

	const ocultarAlertaObligatorios = cerrarModal;

	// Fecha de hoy por defecto (hora local, sin desfase de zona horaria)
	const hoy = new Date();
	fecha.value = `${hoy.getFullYear()}-${String(hoy.getMonth() + 1).padStart(2, '0')}-${String(hoy.getDate()).padStart(2, '0')}`;

	// El celular acepta solo números, espacios y los símbolos + ( )
	celular.addEventListener('input', () => { celular.value = celular.value.replace(/[^0-9+()\s]/g, ''); });

	const marcarError = (campo, si) => campo.classList.toggle('error', !!si);
	const mensaje = (txt, ok) => {
		estado.textContent = txt;
		estado.classList.toggle('ok', !!ok);
		estado.classList.toggle('error', !ok);
	};

	// dd/mm/yyyy para mostrarlo bonito (el input date llega yyyy-mm-dd)
	const fechaVisible = () => {
		if (!fecha.value) return '';
		const [y, m, d] = fecha.value.split('-');
		return `${d}/${m}/${y}`;
	};

	// Todos los campos son obligatorios. Se revisan en el orden en que
	// aparecen y se devuelve la lista de los que faltan rellenar.
	const validar = () => {
		const revisados = [
			{ campo: cotizar,   nombre: 'Cotizar',          ok: cotizar.value !== '' },
			{ campo: pasajeros, nombre: 'N° de pasajeros',  ok: parseInt(pasajeros.value) >= 1 },
			{ campo: dias,      nombre: 'Días',             ok: parseInt(dias.value) >= 1 },
			{ campo: fecha,     nombre: 'Fecha',            ok: fecha.value !== '' },
			{ campo: ruta,      nombre: 'Ruta',             ok: ruta.value.trim() !== '' },
			{ campo: cliente,   nombre: 'Cliente',          ok: cliente.value.trim() !== '' },
			{ campo: salida,    nombre: 'Salida',           ok: salida.value !== '' },
			{ campo: retorno,   nombre: 'Retorno',          ok: retorno.value !== '' },
			{ campo: celular,   nombre: 'Celular / WhatsApp', ok: celular.value.trim() !== '' }
		];

		revisados.forEach((r) => marcarError(r.campo, !r.ok));

		const faltantes = revisados.filter((r) => !r.ok);

		if (faltantes.length > 0) {
			const nombres = faltantes.map((r) => r.nombre);

			// Mensaje corto bajo el botón + modal de aviso
			mensaje('Faltan ' + nombres.length + ' campo(s) obligatorio(s)', false);
			faltantes[0].campo.focus();
			mostrarAlertaObligatorios(nombres);

			return false;
		}

		ocultarAlertaObligatorios();
		return true;
	};

	// Al corregir un campo se le quita la marca roja
	const campos = [cotizar, pasajeros, dias, fecha, ruta, cliente, salida, retorno, celular, correo];
	campos.forEach((campo) => {
		const limpiar = () => {
			campo.classList.remove('error');
			if (!campos.some((c) => c.classList.contains('error'))) mensaje('', true);
		};
		campo.addEventListener('input', limpiar);
		campo.addEventListener('change', limpiar);
	});

	// ===== Vehículos: selección múltiple (máximo 3) con check y badges =====
	const MAX_VEHICULOS = 3;
	const vehiculoBoton  = $('vehiculoBoton');
	const vehiculoMenu   = $('vehiculoMenu');
	const vehiculoBadges = $('vehiculoBadges');
	const vehiculoEtiqueta = $('vehiculoEtiqueta');
	const vehiculoNota   = vehiculoMenu.querySelector('.vehiculo-nota');
	const vehiculoChecks = Array.prototype.slice.call(vehiculoMenu.querySelectorAll('input[type="checkbox"]'));

	const vehiculosElegidos = () => vehiculoChecks.filter((c) => c.checked).map((c) => c.value);

	const pintarVehiculos = () => {
		const elegidos = vehiculosElegidos();

		// Texto del botón: cuántos vehículos van marcados
		vehiculoBoton.textContent = elegidos.length === 0
			? 'Selecciona vehículo'
			: elegidos.length + (elegidos.length === 1 ? ' vehículo' : ' vehículos');

		// La etiqueta "Seleccionados" aparece recién con la primera selección
		vehiculoEtiqueta.classList.toggle('d-none', elegidos.length === 0);

		// Un badge por vehículo, con su botón para quitarlo
		vehiculoBadges.innerHTML = '';
		elegidos.forEach((nombre) => {
			const badge = document.createElement('span');
			badge.className = 'badge text-bg-primary d-inline-flex align-items-center gap-1';

			const texto = document.createElement('span');
			texto.textContent = nombre;
			badge.appendChild(texto);

			const quitar = document.createElement('button');
			quitar.type = 'button';
			quitar.className = 'btn-close btn-close-white';
			quitar.setAttribute('aria-label', 'Quitar ' + nombre);
			quitar.addEventListener('click', () => {
				vehiculoChecks.find((c) => c.value === nombre).checked = false;
				pintarVehiculos();
			});
			badge.appendChild(quitar);

			vehiculoBadges.appendChild(badge);
		});

		// Con el máximo alcanzado solo quedan activos los ya marcados
		const lleno = elegidos.length >= MAX_VEHICULOS;
		vehiculoChecks.forEach((check) => {
			const bloqueado = lleno && !check.checked;
			check.disabled = bloqueado;
			check.parentElement.classList.toggle('bloqueado', bloqueado);
		});

		vehiculoNota.textContent = lleno
			? 'Máximo ' + MAX_VEHICULOS + ' vehículos (quita uno para cambiar)'
			: 'Máximo ' + MAX_VEHICULOS + ' vehículos';
	};

	const mostrarMenuVehiculos = (si) => {
		vehiculoMenu.classList.toggle('show', si);
		vehiculoBoton.setAttribute('aria-expanded', si ? 'true' : 'false');
	};

	vehiculoChecks.forEach((check) => check.addEventListener('change', pintarVehiculos));
	vehiculoBoton.addEventListener('click', () => mostrarMenuVehiculos(!vehiculoMenu.classList.contains('show')));
	document.addEventListener('click', (e) => {
		if (!vehiculoMenu.contains(e.target) && !vehiculoBoton.contains(e.target)) mostrarMenuVehiculos(false);
	});
	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape') mostrarMenuVehiculos(false);
	});
	pintarVehiculos();

	// ===== Horas en formato 12 h con a.m. / p.m. (flatpickr) =====
	if (window.flatpickr) {
		flatpickr.localize({ amPM: ['a.m.', 'p.m.'] });

		const opcionesHora = {
			enableTime: true,
			noCalendar: true,
			time_24hr: false,
			dateFormat: 'h:i K',
			minuteIncrement: 5,
			disableMobile: true,
			defaultHour: 8
		};

		// Horas por defecto: salida 7:00 a.m. y retorno 7:00 p.m.
		const horaDeHoy = (horas, minutos) => {
			const cuando = new Date();
			cuando.setHours(horas, minutos, 0, 0);
			return cuando;
		};

		flatpickr(salida, Object.assign({}, opcionesHora, { defaultDate: horaDeHoy(7, 0) }));
		flatpickr(retorno, Object.assign({}, opcionesHora, { defaultDate: horaDeHoy(19, 0) }));
	}

	// Reúne todos los datos del formulario
	const datos = () => ({
		cotizar:   cotizar.value,
		vehiculos: vehiculosElegidos().join(', '),
		pasajeros: parseInt(pasajeros.value) || 0,
		dias:      parseInt(dias.value) || 0,
		fecha:     fechaVisible(),
		ruta:      ruta.value.trim(),
		observaciones: observaciones.value.trim(),
		cliente:   cliente.value.trim(),
		salida:    salida.value,
		retorno:   retorno.value,
		celular:   celular.value.trim(),
		correo:    correo.value.trim(),
		pagina:    document.title.replace(/\s*[-–]\s*Grupo Euro Andino\s*$/, '').trim(),
		url:       window.location.href
	});

	btn.addEventListener('click', () => {
		if (!validar()) return;

		const d = datos();

		// ===== 1. WhatsApp =====
		const lineas = [
			`Servicio: ${d.cotizar}`,
			d.vehiculos ? `Vehículos: ${d.vehiculos}` : '',
			`N° de pasajeros: ${d.pasajeros}`,
			`Días: ${d.dias}`,
			d.fecha   ? `Fecha: ${d.fecha}`   : '',
			d.ruta    ? `Ruta / Itinerario: ${d.ruta}`     : '',
			d.observaciones ? `Observaciones: ${d.observaciones}` : '',
			`Cliente: ${d.cliente}`,
			d.salida  ? `Salida: ${d.salida}` : '',
			d.retorno ? `Retorno: ${d.retorno}` : '',
			d.celular ? `Celular / WhatsApp: ${d.celular}` : '',
			d.correo  ? `Correo Electrónico: ${d.correo}` : ''
		].filter((linea) => linea !== '');

		const texto = `*Hola Grupo Euro Andino* Quisiera una cotización de *${d.cotizar}*\n` + lineas.join('\n');
		window.open(`https://wa.me/${celularWhatsApp}?text=${encodeURIComponent(texto)}`, '_blank');

		// ===== 2. Correo (wp_mail de WordPress vía admin-ajax.php) =====
		btn.disabled = true;
		mensaje('Enviando cotización...', true);

		const fd = new FormData();
		fd.append('action', 'enviar_cotizacion');
		Object.keys(d).forEach((k) => fd.append(k, d[k]));

		fetch(AJAX_URL, { method: 'POST', body: fd })
			.then((res) => res.text())
			.then((resp) => {
				if (resp.trim() === 'exito') {
					mensaje('Cotización enviada a ' + DESTINO_CORREO, true);
					abrirModal(
						'ok',
						'¡Solicitud recibida con éxito!',
						'✅',
						'<p style="margin:0 0 12px;font-size:1.05rem;">Gracias por contactarnos. Hemos recibido los detalles de tu ruta y nuestro equipo de Grupo Euro Andino está preparando tu cotización. En breve nos comunicaremos contigo vía WhatsApp o correo electrónico.</p>' +
						'<p style="margin:0;">¿Necesitas atención urgente? Escríbenos directo al WhatsApp: ' +
							'<a href="https://wa.me/51947614293" target="_blank" rel="noopener" style="color:#10b916;font-weight:700;text-decoration:none;">(+51) 947614293</a>' +
						'</p>',
						'Cerrar'
					);
				} else {
					mensaje('No se pudo enviar el correo (revisa la config. de correo del sitio)', false);
				}
			})
			.catch(() => mensaje('No se pudo enviar el correo', false))
			.finally(() => { btn.disabled = false; });
	});
})();
</script>
