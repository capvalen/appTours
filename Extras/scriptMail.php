<?php
add_action('wp_ajax_enviar_correo_contacto', 'procesar_formulario_contacto');
add_action('wp_ajax_nopriv_enviar_correo_contacto', 'procesar_formulario_contacto');

function procesar_formulario_contacto() {
	//var_dump($_POST); die();
    // 1. Recoger datos
    $adultos = intval($_POST['adultos']);
    $nombre = sanitize_text_field($_POST['nombre']);
    $email  = sanitize_text_field($_POST['email']);
    $celular  = sanitize_text_field($_POST['celular']);
    $pagina = sanitize_text_field($_POST['pagina']);
    $fecha = sanitize_text_field($_POST['fecha']);
    $nacionalidad = sanitize_text_field($_POST['nacionalidad']) == 1? 'Peruano':'Extranjero';
    $adultos = intval($_POST['adultos'] ?? 0);
    $ninos = intval($_POST['niños'] ?? 0);
	
    // 2. Configurar el correo
    $destinatario = 'grupoeuroandino0@hotmail.com';
    $asunto = 'Nuevo interesado: ' . $nombre;
    $cuerpo = "Has recibido un nuevo mensaje de una persona interesada:<br><br>" .
              "<b>Tour:</b> $pagina<br>" .
              "<b>Fecha:</b> $fecha<br>" .
              "<b>Nacionalidad:</b> $nacionalidad<br>" .
              "<b>Pasajeros:</b> $adultos (adultos) y $ninos (niños)<br>" .
              "<b>Nombre:</b> $nombre<br>" .
              "<b>celular:</b> $celular<br>" .
              "<b>Email:</b> $email<br>" 
		;

	// CAPTURAR ERRORES DE PHPMAILER
    add_action('wp_mail_failed', function($error) {
        error_log("Error de wp_mail: " . $error->get_error_message());
    });
	
    // 3. Enviar
		$headers = array('Content-Type: text/html; charset=UTF-8');
    $enviado = wp_mail($destinatario, $asunto, $cuerpo, $headers);

    if ($enviado) {
        echo 'exito';
    } else {
        echo 'error';
    }

    wp_die(); // Obligatorio en AJAX de WordPress
}