<?php
/**
 * Plugin Name: Integración Tours
 * Description: Carga template-viajes.php en /tours/lo-que-sea, template-tour-ciudades.php en /tours-y-paquetes/lo-que-sea, template-paquetes.php en /paquetes-y-tours/lo-que-sea, template-tienda.php en las rutas de tienda y template-transporte-turistico.php en /transporte-turistico-en-peru.
 * Version: 1.3.1
 * Author: Carlos Pariona
 *
 * Rutas gestionadas:
 *   - /tours/{texto}                        -> template-viajes.php
 *   - /tours-y-paquetes/{texto}             -> template-tour-ciudades.php
 *   - /paquetes-y-tours/{texto}             -> template-paquetes.php
 *   - /viajes-de-promocion-escolar-en-peru  -> template-tienda.php  (idCategoria=38, idDia=-1)
 *   - /half-days-en-peru                    -> template-tienda.php  (idCategoria=-1, idDia=0)
 *   - /full-days-en-peru                    -> template-tienda.php  (idCategoria=-1, idDia=1)
 *   - /tours-en-peru                         -> template-tienda.php  (idCategoria=-1, idDia=-1)
 *   - /paquetes-turisticos-en-peru           -> template-tienda.php
 *   - /registro-panel                        -> template-panel.php (registro de cuenta)
 *   - /login-panel                           -> template-login-panel.php (inicio de sesión)
 *   - /transporte-turistico-en-peru           -> template-transporte-turistico.php (formulario de cotización; vista=transporte-turistico)
 *
 * Acciones AJAX:
 *   - enviar_cotizacion -> procesar_cotizacion() (wp_mail a grupoeuroandino@hotmail.com)
 */

// 1. Le dice a WordPress que reconozca los parámetros "variable", "vista", "tour_ciudades" y "paquetes_tours"
add_filter('query_vars', function($vars) {
	$vars[] = 'variable';
	$vars[] = 'vista';
	$vars[] = 'tour_ciudades';
	$vars[] = 'paquetes_tours';
	return $vars;
});

// 2. Reglas de reescritura
add_action('init', function() {

	// /tours/lo-que-sea-texto -> index.php?variable=lo-que-sea-texto
	add_rewrite_rule(
		'^tours/([^/]+)/?$',
		'index.php?variable=$matches[1]',
		'top'
	);

	// /tours-y-paquetes/lo-que-sea -> index.php?tour_ciudades=lo-que-sea
	add_rewrite_rule(
		'^tours-y-paquetes/([^/]+)/?$',
		'index.php?tour_ciudades=$matches[1]',
		'top'
	);

	// /paquetes-y-tours/lo-que-sea -> index.php?paquetes_tours=lo-que-sea
	add_rewrite_rule(
		'^paquetes-y-tours/([^/]+)/?$',
		'index.php?paquetes_tours=$matches[1]',
		'top'
	);

	// Rutas de la tienda -> index.php?vista=...
	add_rewrite_rule(
		'^(viajes-de-promocion-escolar-en-peru|half-days-en-peru|full-days-en-peru|tours-en-peru|paquetes-turisticos-en-peru|registro-panel|login-panel)/?$',
		'index.php?vista=$matches[1]',
		'top'
	);

	// /transporte-turistico-desde-peru -> index.php?vista=transporte-turistico
	add_rewrite_rule(
		'^transporte-turistico-desde-peru/?$',
		'index.php?vista=transporte-turistico',
		'top'
	);
});

// 3. Cuando llega ese parámetro, carga la plantilla en vez de la normal
add_filter('template_include', function($template) {

  // Rutas que usan template-tienda.php
	$vistas_tienda = [
		'viajes-de-promocion-escolar-en-peru',
		'half-days-en-peru',
		'full-days-en-peru',
		'tours-en-peru',
		'paquetes-turisticos-en-peru',
	];
	$vista = get_query_var('vista');

	// La ruta /registro-panel carga el registro del panel de usuario (template-panel.php)
	if ($vista === 'registro-panel') {
			return get_theme_file_path('template-panel.php');
	}

	// La ruta /login-panel carga el login del panel de usuario (template-login-panel.php)
	if ($vista === 'login-panel') {
			return get_theme_file_path('template-login-panel.php');
	}

	// La ruta /transporte-turistico carga el formulario de cotización
	if ($vista === 'transporte-turistico') {
			return get_theme_file_path('template-transporte-turistico.php');
	}

	//si la url contiene el parametro vista, carga el template-tienda.php
	if (in_array($vista, $vistas_tienda, true)) {
			return get_theme_file_path('template-tienda.php');
	}

	if (get_query_var('variable')) {
			return get_theme_file_path('template-viajes.php');
	}

	// La ruta /tours-y-paquetes/{texto} carga el filtrado de ciudades (template-tour-ciudades.php)
	if (get_query_var('tour_ciudades')) {
			return get_theme_file_path('template-tour-ciudades.php');
	}

	// La ruta /paquetes-y-tours/{texto} carga el filtrado de departamentos (template-paquetes.php)
	if (get_query_var('paquetes_tours')) {
			return get_theme_file_path('template-paquetes.php');
	}

	return $template;
});

// 4. AJAX: cotización de transporte (formulario de /transporte-turistico).
//    Se envía el correo con wp_mail() de WordPress. El JavaScript del template
//    hace el POST a admin-ajax.php con action=enviar_cotizacion.
add_action('wp_ajax_enviar_cotizacion', 'procesar_cotizacion_transporte');
add_action('wp_ajax_nopriv_enviar_cotizacion', 'procesar_cotizacion_transporte');

function procesar_cotizacion_transporte() {

	// 1. Recoger y limpiar datos
	$cotizar   = sanitize_text_field($_POST['cotizar'] ?? '');
	$vehiculos = sanitize_text_field($_POST['vehiculos'] ?? '');
	$pasajeros = intval($_POST['pasajeros'] ?? 0);
	$dias      = intval($_POST['dias'] ?? 0);
	$fecha     = sanitize_text_field($_POST['fecha'] ?? '');
	$ruta      = sanitize_textarea_field($_POST['ruta'] ?? '');
	$observaciones = sanitize_textarea_field($_POST['observaciones'] ?? '');
	$cliente   = sanitize_text_field($_POST['cliente'] ?? '');
	$salida    = sanitize_text_field($_POST['salida'] ?? '');
	$retorno   = sanitize_text_field($_POST['retorno'] ?? '');
	$celular   = sanitize_text_field($_POST['celular'] ?? '');
	$correo    = sanitize_email($_POST['correo'] ?? '');
	$pagina    = sanitize_text_field($_POST['pagina'] ?? '');
	$url       = esc_url_raw($_POST['url'] ?? '');

	// 2. Marca del sitio: se extrae de $url todo lo que va ANTES de ".com"
	//    Ej: https://www.tourshuancayo.com/transporte-turistico -> "Tourshuancayo"
	$host = wp_parse_url($url, PHP_URL_HOST);
	$host = $host ? preg_replace('/^www\./i', '', $host) : '';

	if ($host !== '') {
		$pos   = stripos($host, '.com');
		$marca = $pos !== false ? substr($host, 0, $pos) : explode('.', $host)[0];
		$marca = ucfirst($marca);
	} else {
		$marca = '';
	}

	// Paleta en tonos azules
	$azul       = '#0d6efd';
	$azulFuerte = '#0a4bb5';
	$azulClaro  = '#dbe9ff';

	// Fila "Label: valor" para la tabla del correo
	$fila = function ($label, $valor) {
		if ($valor === '' || $valor === null) return '';

		return '<tr>' .
			'<td style="padding:6px 0;font-size:14px;font-weight:bold;color:#2b2b2b;vertical-align:top;">' . esc_html($label) . ':</td>' .
			'<td style="padding:6px 0;font-size:14px;text-align:right;vertical-align:top;word-break:break-word;">' .
				'<span style="color:#5a5a5a;">' . nl2br(esc_html($valor)) . '</span>' .
			'</td>' .
		'</tr>';
	};

	// Enlace de la página
	$filaUrl = '';
	if ($url !== '') {
		$filaUrl = '<tr>' .
			'<td style="padding:6px 0;font-size:14px;font-weight:bold;color:#2b2b2b;vertical-align:top;">Url:</td>' .
			'<td style="padding:6px 0;font-size:13px;text-align:right;vertical-align:top;word-break:break-all;">' .
				'<a href="' . esc_url($url) . '" style="color:' . $azul . ';text-decoration:none;">' . esc_html($url) . '</a>' .
			'</td>' .
		'</tr>';
	}

	// 3. Correo
	$destinatario = 'grupoeuroandino@hotmail.com';
	$asunto = 'Nueva cotización de Transporte: ' . ($cotizar !== '' ? $cotizar : 'transporte') . ' - ' . ($cliente !== '' ? $cliente : 'sin nombre');

	$cuerpo = '<!DOCTYPE html>' .
	'<html lang="es"><head><meta charset="UTF-8"><title>Nueva Cotización</title></head>' .
	'<body style="margin:0;padding:0;background:#f2f2f2;">' .
		'<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f2f2f2;padding:28px 12px;">' .
			'<tr><td align="center">' .

				'<table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" ' .
					'style="width:100%;max-width:600px;background:#ffffff;border-radius:14px;border:1px solid #e6e6e6;font-family:Arial,Helvetica,sans-serif;overflow:hidden;">' .

					// Cabecera
					'<tr><td style="background:' . $azul . ';padding:24px;text-align:center;">' .
						'<div style="font-size:11px;letter-spacing:2px;text-transform:uppercase;color:' . $azulClaro . ';font-weight:bold;">Transporte Turístico</div>' .
						'<div style="font-size:20px;font-weight:bold;color:#ffffff;padding-top:6px;">Nueva Cotización solicitada</div>' .
					'</td></tr>' .

					// Cuerpo
					'<tr><td style="padding:22px 26px 6px;">' .
						'<p style="margin:0 0 14px;font-size:14px;color:#6f6f6f;line-height:1.5;">Se ha recibido una nueva solicitud de cotización con estos datos:</p>' .

						'<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">' .
							$fila('Servicio', $cotizar) .
							$fila('Vehículos', $vehiculos) .
							$fila('N° de pasajeros', $pasajeros) .
							$fila('Días', $dias) .
							$fila('Fecha', $fecha) .
							$fila('Ruta / Itinerario', $ruta) .
							$fila('Observaciones', $observaciones) .
							$fila('Cliente', $cliente) .
							$fila('Salida', $salida) .
							$fila('Retorno', $retorno) .
							$fila('Celular / WhatsApp', $celular) .
							$fila('Correo Electrónico', $correo) .
							$fila('Página', $pagina) .
							$filaUrl .
						'</table>' .
					'</td></tr>' .

					// Pie con la marca del dominio
					'<tr><td style="padding:18px 26px 22px;">' .
						'<div style="border-top:1px solid #ededed;padding-top:14px;text-align:center;font-size:12px;color:#9a9a9a;line-height:1.6;">' .
							($marca !== ''
								? '<strong style="color:#4d4d4d;font-size:13px;letter-spacing:1px;text-transform:uppercase;">' . esc_html($marca) . '</strong><br>'
								: '') .
							'Cotización enviada desde ' .
							'<a href="' . esc_url($url) . '" style="color:' . $azulFuerte . ';text-decoration:none;">' . esc_html($host !== '' ? $host : $url) . '</a>' .
						'</div>' .
					'</td></tr>' .

				'</table>' .

			'</td></tr>' .
		'</table>' .
	'</body></html>';

	// 4. Cabeceras (HTML). Si dejaron un celular, se agrega como Reply-To simple
	$headers = array('Content-Type: text/html; charset=UTF-8');

	// Capturar errores de PHPMailer en el log
	add_action('wp_mail_failed', function ($error) {
		error_log('Error de wp_mail (cotización): ' . $error->get_error_message());
	});

	// 5. Enviar
	$enviado = wp_mail($destinatario, $asunto, $cuerpo, $headers);

	echo $enviado ? 'exito' : 'error';

	wp_die(); // Obligatorio en AJAX de WordPress
}