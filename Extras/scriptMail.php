<?php
add_action('wp_ajax_enviar_correo_contacto', 'procesar_formulario_contacto');
add_action('wp_ajax_nopriv_enviar_correo_contacto', 'procesar_formulario_contacto');

function procesar_formulario_contacto() {
	//var_dump($_POST); die();
	// 1. Recoger datos
	$nombre       = sanitize_text_field($_POST['nombre'] ?? '');
	$email        = sanitize_email($_POST['email'] ?? '');
	$celular      = sanitize_text_field($_POST['celular'] ?? '');
	$pagina       = sanitize_text_field($_POST['pagina'] ?? '');
	$url          = esc_url_raw($_POST['url'] ?? '');
	$fecha        = sanitize_text_field($_POST['fecha'] ?? '');
	$adultos      = intval($_POST['adultos'] ?? 0);
	$ninos        = intval($_POST['niños'] ?? 0);
	$pais         = sanitize_text_field($_POST['pais'] ?? '');
	$nacionalidad = sanitize_text_field($_POST['nacionalidad'] ?? '');
	$documento       = sanitize_text_field($_POST['documento'] ?? '');
	$numeroDocumento = sanitize_text_field($_POST['numeroDocumento'] ?? '');
	$ciudad          = sanitize_text_field($_POST['ciudad'] ?? '');
	$direccion       = sanitize_text_field($_POST['direccion'] ?? '');
	$precio          = floatval($_POST['precio'] ?? 0);

	// Total a pagar: precio x (adultos + niños). Si no llega el precio,
	// se usa el total que envió el cliente como respaldo.
	$total = $precio > 0
		? $precio * ($adultos + $ninos)
		: floatval($_POST['total'] ?? 0);

	// La nacionalidad llega como "Peruana"/"Extranjera" (formulario nuevo)
	// o como "1" (peruano) / "2" (extranjero) en formularios antiguos
	$nacionalidadTexto = $nacionalidad;

	if ($nacionalidadTexto === '1' || stripos($nacionalidadTexto, 'peru') === 0) {
		$nacionalidad = 'Peruano';
	} elseif ($nacionalidadTexto !== '') {
		$nacionalidad = 'Extranjero';
	}

	// Respaldo: si el país no llegó en su propio campo (cliente antiguo que
	// enviaba el país o el número dentro de "nacionalidad"), se usa ese texto
	if ($pais === '' && $nacionalidadTexto !== '' &&
		!in_array($nacionalidadTexto, array('Peruana', 'Extranjera', 'Peruano', 'Extranjero', '1', '2'), true)) {
		$pais = $nacionalidadTexto;
	}

	// 2. Validar y subir la constancia de pago
	// IMPORTANTE: WordPress espera el array como ['extension' => 'mime'],
	// igual que get_allowed_mime_types(). Si se pone al reves, la validacion
	// falla siempre y devuelve error_tipo.
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'png'          => 'image/png',
		'webp'         => 'image/webp',
		'gif'          => 'image/gif',
		'pdf'          => 'application/pdf',
	);

	// Mime types permitidos (para comparar lo que devuelve WordPress)
	$tipos_permitidos = array(
		'image/jpeg',
		'image/png',
		'image/webp',
		'image/gif',
		'application/pdf',
	);

	$adjuntos = array();

	if (!empty($_FILES['comprobante']['name'])) {
		require_once ABSPATH . 'wp-admin/includes/file.php';

		$file = $_FILES['comprobante'];

		if ($file['error'] !== UPLOAD_ERR_OK) {
			echo 'error_archivo';
			wp_die();
		}
		if ($file['size'] > 8 * 1024 * 1024) {
			echo 'error_peso';
			wp_die();
		}

		// Verifica el tipo real del archivo (no solo la extension)
		$check = wp_check_filetype_and_ext($file['tmp_name'], $file['name'], $mimes);
		if (empty($check['ext']) || empty($check['type']) || !in_array($check['type'], $tipos_permitidos, true)) {
			error_log(sprintf(
				'[reserva] error_tipo | archivo: %s | detectado: ext=%s type=%s mime_cliente=%s',
				$file['name'],
				var_export($check['ext'], true),
				var_export($check['type'], true),
				var_export($file['type'], true)
			));
			echo 'error_tipo';
			wp_die();
		}

		$subida = wp_handle_upload($file, array(
			'test_form' => false,
			'mimes'     => $mimes,
		));

		if (isset($subida['error']) || empty($subida['file'])) {
			error_log('[reserva] error_subida | ' . (isset($subida['error']) ? $subida['error'] : 'sin ruta de archivo'));
			echo 'error_subida';
			wp_die();
		}

		$adjuntos[] = $subida['file'];
	}

	// 3. Marca del sitio: se extrae de $url todo lo que va ANTES de ".com"
	//    Ej: https://www.tourshuancayo.com/tours/cusco -> "Tourshuancayo"
	//    Así la misma plantilla sirve para varios dominios.
	$host = wp_parse_url($url, PHP_URL_HOST);
	$host = $host ? preg_replace('/^www\./i', '', $host) : '';

	if ($host !== '') {
		$pos   = stripos($host, '.com');
		$marca = $pos !== false ? substr($host, 0, $pos) : explode('.', $host)[0];
		$marca = ucfirst($marca);
	} else {
		$marca = '';
	}

	// Piezas de la plantilla
	$naranja = '#ffa300';

	// Fila "Label: valor" (tabla, para que se vea bien en los clientes de correo)
	$fila = function ($label, $valor, $esFuerte = false) {
		if ($valor === '' || $valor === null) return '';

		$v = $esFuerte
			? '<strong style="color:#ffa300;font-size:15px;">' . $valor . '</strong>'
			: '<span style="color:#5a5a5a;">' . esc_html($valor) . '</span>';

		return '<tr>' .
			'<td style="padding:6px 0;font-size:14px;font-weight:bold;color:#2b2b2b;vertical-align:top;">' . esc_html($label) . ':</td>' .
			'<td style="padding:6px 0;font-size:14px;text-align:right;vertical-align:top;word-break:break-word;">' . $v . '</td>' .
		'</tr>';
	};

	// Enlace de la página (se muestra como texto y como enlace)
	$filaUrl = '';
	if ($url !== '') {
		$filaUrl = '<tr>' .
			'<td style="padding:6px 0;font-size:14px;font-weight:bold;color:#2b2b2b;vertical-align:top;">Url:</td>' .
			'<td style="padding:6px 0;font-size:13px;text-align:right;vertical-align:top;word-break:break-all;">' .
				'<a href="' . esc_url($url) . '" style="color:' . $naranja . ';text-decoration:none;">' . esc_html($url) . '</a>' .
			'</td>' .
		'</tr>';
	}

	// 4. Configurar el correo
	$destinatario = 'grupoeuroandino@hotmail.com';
	$asunto = 'Se ha realizado una reserva: ' . $nombre;

	$cuerpo = '<!DOCTYPE html>' .
	'<html lang="es"><head><meta charset="UTF-8"><title>Nueva Reserva</title></head>' .
	'<body style="margin:0;padding:0;background:#f2f2f2;">' .
		'<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f2f2f2;padding:28px 12px;">' .
			'<tr><td align="center">' .

				'<table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" ' .
					'style="width:100%;max-width:600px;background:#ffffff;border-radius:14px;border:1px solid #e6e6e6;font-family:Arial,Helvetica,sans-serif;overflow:hidden;">' .

					// Cabecera
					'<tr><td style="background:' . $naranja . ';padding:24px;text-align:center;">' .
						'<div style="font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#fff3dd;font-weight:bold;">Pre-Reserva</div>' .
						'<div style="font-size:20px;font-weight:bold;color:#ffffff;padding-top:6px;">Nueva Reserva recibida</div>' .
					'</td></tr>' .

					// Cuerpo
					'<tr><td style="padding:22px 26px 6px;">' .
						'<p style="margin:0 0 14px;font-size:14px;color:#6f6f6f;line-height:1.5;">Se ha recibido una nueva reserva con estos datos:</p>' .

						'<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">' .
							$fila('Tour', $pagina) .
							$fila('Fecha', $fecha) .
							$fila('País', $pais) .
							$fila('Nacionalidad', $nacionalidad) .
							$fila('Documento', $documento) .
							$fila('N° de documento', $numeroDocumento) .
							$filaUrl .
							$fila('Nombre', $nombre) .
							$fila('Celular', $celular) .
							$fila('Email', $email) .
							$fila('Ciudad', $ciudad) .
							$fila('Dirección', $direccion) .
							$fila('Pasajeros', $adultos . ' (adultos) y ' . $ninos . ' (niños)') .
							$fila('Precio por persona', 'S/ ' . number_format($precio, 2)) .
							$fila('Constancia de pago', $adjuntos ? 'Sí, adjunta' : 'No adjuntada') .
						'</table>' .

						// Total destacado
						'<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:14px;border-top:1px dashed #e0e0e0;">' .
							'<tr>' .
								'<td style="padding-top:14px;font-size:15px;font-weight:bold;color:#2b2b2b;">Total a pagar:</td>' .
								'<td style="padding-top:14px;font-size:20px;font-weight:bold;color:' . $naranja . ';text-align:right;">S/ ' . number_format($total, 2) . '</td>' .
							'</tr>' .
						'</table>' .
					'</td></tr>' .

					// Pie con la marca del dominio
					'<tr><td style="padding:18px 26px 22px;">' .
						'<div style="border-top:1px solid #ededed;padding-top:14px;text-align:center;font-size:12px;color:#9a9a9a;line-height:1.6;">' .
							($marca !== ''
								? '<strong style="color:#4d4d4d;font-size:13px;letter-spacing:1px;text-transform:uppercase;">' . esc_html($marca) . '</strong><br>'
								: '') .
							'Reserva enviada desde ' .
							'<a href="' . esc_url($url) . '" style="color:' . $naranja . ';text-decoration:none;">' . esc_html($host !== '' ? $host : $url) . '</a>' .
						'</div>' .
					'</td></tr>' .

				'</table>' .

			'</td></tr>' .
		'</table>' .
	'</body></html>';

	// 5. Cabeceras: HTML + copia (CC) al correo del cliente
	$headers   = array('Content-Type: text/html; charset=UTF-8');
	if ($email && is_email($email)) {
		$headers[] = 'Cc: ' . $email;
	}

	// CAPTURAR ERRORES DE PHPMAILER
	add_action('wp_mail_failed', function($error) {
		error_log("Error de wp_mail: " . $error->get_error_message());
	});

	// 6. Enviar (con el adjunto)
	$enviado = wp_mail($destinatario, $asunto, $cuerpo, $headers, $adjuntos);

	// 7. Borrar el archivo subido después de enviarlo
	foreach ($adjuntos as $ruta) {
		if (file_exists($ruta)) {
			@unlink($ruta);
		}
	}

	echo $enviado ? 'exito' : 'error';

	wp_die(); // Obligatorio en AJAX de WordPress
}