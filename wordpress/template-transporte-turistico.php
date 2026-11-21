<?php
/**
 * Template: /transporte-turistico-desde-peru (vista=transporte-turistico)
 *
 * Formulario de COTIZACIÓN (2 columnas 3:1) para transporte / servicios turísticos.
 * Al pulsar ENVIAR se manda todo a la vez:
 *   - WhatsApp (número según el dominio, igual que Extras/formularioContacto.html)
 *   - Correo a grupoeuroandino@hotmail.com usando wp_mail de WordPress
 *     (el handler AJAX "enviar_cotizacion" vive en tours-infocat-plugin.php)
 *
 * OJO: este archivo debe copiarse a la carpeta del TEMA activo
 * (el plugin lo carga con get_theme_file_path('template-transporte-turistico.php')).
 */

// Host sin "www" (igual que template-viajes.php / template-paquetes.php)
$host = preg_replace('#^www\.#i', '', parse_url('http://' . $_SERVER['HTTP_HOST'], PHP_URL_HOST));

// Metas básicas (patrón wpseo de los demás templates)
$tt_titulo = 'Cotización de Transporte Turístico - Grupo Euro Andino';
add_filter('wpseo_title', function ($title) use ($tt_titulo) {
	return $tt_titulo;
});

get_header();

// CSS de la app (igual que el resto de templates)
if ($host === 'grupoeuroandino.com')
	include('/home/fhuczgkg/public_html/app/render/headers.php');
else
	include('headers.php');

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
?>

<style>
	#cotizacionApp { margin-top: 20px; margin-bottom: 40px; }

	/* Campos */
	#cotizacionApp .campo label {
		display: block;
		font-weight: 600;
		font-size: .9rem;
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
	#cotizacionApp .error { border: 1px solid #e21212 !important; }

	/* Panel derecho */
	#cotizacionApp .cotizacion-titulo {
		background: #000;
		color: #fff;
		width: 100%;
		padding: 10px 12px;
		font-weight: 700;
		font-size: 1.15rem;
		text-align: center;
		letter-spacing: .5px;
	}
	#cotizacionApp .cotizacion-caja {
		border: 1px solid #e6e6e6;
		border-radius: 8px;
		overflow: hidden;
		background: #fff;
	}
	#cotizacionApp .cotizacion-caja .cotizacion-body { padding: 20px 18px; }

	/* Botón enviar */
	#cotizacionApp .btn-enviar {
		background: #dc3545;
		color: #fff;
		border: 0;
		border-radius: 6px;
		padding: 12px;
		font-weight: 700;
		letter-spacing: .5px;
		text-transform: uppercase;
	}
	#cotizacionApp .btn-enviar:hover { background: #b02a37; color: #fff; }
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
		padding: 16px 20px;
		font-weight: 700;
		font-size: 1.1rem;
		color: #fff;
	}
	#cotizacionApp .cotizacion-modal .modal-cabecera .alerta-icono {
		font-size: 1.3rem;
		line-height: 1;
	}
	#cotizacionApp .cotizacion-modal .modal-cabecera.error { background: #dc3545; }
	#cotizacionApp .cotizacion-modal .modal-cabecera.ok { background: #10b916; }
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
		border: 0;
		border-radius: 8px;
		padding: 12px;
		color: #fff;
		font-weight: 700;
		letter-spacing: .5px;
		text-transform: uppercase;
	}
	#cotizacionApp .cotizacion-modal .modal-btn.error { background: #dc3545; }
	#cotizacionApp .cotizacion-modal .modal-btn.error:hover { background: #b02a37; }
	#cotizacionApp .cotizacion-modal .modal-btn.ok { background: #10b916; }
	#cotizacionApp .cotizacion-modal .modal-btn.ok:hover { background: #0d9a12; }
	body.cotizacion-modal-abierto { overflow: hidden; }

	@media (max-width: 991px) {
		/* En móvil el panel derecho pasa debajo, con un margen extra */
		#cotizacionApp .col-derecha { margin-top: 16px; }
	}
</style>

<div class="container" id="cotizacionApp">
	<div class="row g-3 g-xl-4">

		<!-- ===== Columna izquierda (3 de 4) ===== -->
		<div class="col-12 col-lg-9">
			<div class="row g-3">

				<!-- Cotizar -->
				<div class="col-12 campo">
					<label for="cotizar">Cotizar: <span class="obligatorio">*</span></label>
					<select id="cotizar" class="form-select">
						<option value="">Selecciona el servicio</option>
						<?php foreach ($tt_servicios as $tt_servicio): ?>
							<option value="<?= esc_attr($tt_servicio); ?>"><?= esc_html($tt_servicio); ?></option>
						<?php endforeach; ?>
					</select>
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

				<!-- Ruta -->
				<div class="col-12 campo">
					<label for="ruta">Ruta: <span class="obligatorio">*</span></label>
					<textarea id="ruta" class="form-control" rows="2" placeholder="Itinerario"></textarea>
				</div>

				<!-- Cliente -->
				<div class="col-12 campo">
					<label for="cliente">Cliente: <span class="obligatorio">*</span></label>
					<input type="text" id="cliente" class="form-control" placeholder="Nombre o empresa" autocomplete="off">
				</div>

			</div>
		</div>

		<!-- ===== Columna derecha (1 de 4) ===== -->
		<div class="col-12 col-lg-3 col-derecha">
			<div class="cotizacion-caja">

				<!-- Título -->
				<div class="cotizacion-titulo">Cotización</div>

				<div class="cotizacion-body">
					<!-- Salida -->
					<div class="campo mb-4">
						<label for="salida">Salida <span class="obligatorio">*</span></label>
						<input type="time" id="salida" class="form-control">
					</div>

					<!-- Retorno -->
					<div class="campo mb-4">
						<label for="retorno">Retorno <span class="obligatorio">*</span></label>
						<input type="time" id="retorno" class="form-control">
					</div>

					<!-- Celular -->
					<div class="campo mb-4">
						<label for="celular">Celular <span class="obligatorio">*</span></label>
						<input type="tel" id="celular" class="form-control" inputmode="numeric" autocomplete="off" placeholder="Solo números">
					</div>

					<!-- Enviar -->
					<button type="button" id="btnEnviar" class="btn-enviar w-100 d-block">Enviar</button>

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

<script>
(function () {
	// ===== Celular de WhatsApp según el dominio del servidor =====
	// Copiado tal cual de Extras/formularioContacto.html (el 51 de Perú va siempre delante)
	// OJO: todo va con ";" al final porque el tema/plugins pueden quitar los
	// saltos de línea al concatenar los <script> (sin ";" el JS se rompe).
	const PREFIJO_PAIS = '51';
	const CELULAR_POR_DOMINIO = {
		'toursjauja.com': '956323084'
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
	const cliente   = $('cliente');
	const salida    = $('salida');
	const retorno   = $('retorno');
	const celular   = $('celular');
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

	// El celular acepta solo números
	celular.addEventListener('input', () => { celular.value = celular.value.replace(/\D/g, ''); });

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
			{ campo: celular,   nombre: 'Celular',          ok: celular.value.trim() !== '' }
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
	const campos = [cotizar, pasajeros, dias, fecha, ruta, cliente, salida, retorno, celular];
	campos.forEach((campo) => {
		const limpiar = () => {
			campo.classList.remove('error');
			if (!campos.some((c) => c.classList.contains('error'))) mensaje('', true);
		};
		campo.addEventListener('input', limpiar);
		campo.addEventListener('change', limpiar);
	});

	// Reúne todos los datos del formulario
	const datos = () => ({
		cotizar:   cotizar.value,
		pasajeros: parseInt(pasajeros.value) || 0,
		dias:      parseInt(dias.value) || 0,
		fecha:     fechaVisible(),
		ruta:      ruta.value.trim(),
		cliente:   cliente.value.trim(),
		salida:    salida.value,
		retorno:   retorno.value,
		celular:   celular.value,
		pagina:    document.title.replace(' – Grupo Euro Andino', '').trim(),
		url:       window.location.href
	});

	btn.addEventListener('click', () => {
		if (!validar()) return;

		const d = datos();

		// ===== 1. WhatsApp =====
		const lineas = [
			`Servicio: ${d.cotizar}`,
			`N° de pasajeros: ${d.pasajeros}`,
			`Días: ${d.dias}`,
			d.fecha   ? `Fecha: ${d.fecha}`   : '',
			d.ruta    ? `Ruta: ${d.ruta}`     : '',
			`Cliente: ${d.cliente}`,
			d.salida  ? `Salida: ${d.salida}` : '',
			d.retorno ? `Retorno: ${d.retorno}` : '',
			d.celular ? `Celular: ${d.celular}` : ''
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
						'¡Solicitud enviada!',
						'✅',
						'<p style="margin:0;font-size:1.05rem;">Gracias por cotizar. Te daremos una respuesta pronto.</p>',
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
