<?php
/* $_POST['inicio']='12/06/2026';
$_POST['razonSocial']='Carlos pariona';
$_POST['jsonProductos'][0]['descripcionProducto']='Tour disney'; */

// URL del endpoint
$url = 'https://7105.api.greenapi.com/waInstance7105285338/sendInteractiveButtons/'; //poner token

// Datos a enviar
$data = array(
	'chatId' => '51977692108@c.us',
	'body' => "*Una venta realizada*\n".
		'El cliente _'.$_POST['razonSocial'].'_ ha realizado una compra del paquete _'.$_POST['jsonProductos'][0]['descripcionProducto']."_\n".'Para la fecha _'.$_POST['inicio']."_\n\n🐱 Revisa tu bandeja de sistema",
	'buttons' => array(
		array(
			"type"=> "url",
			"buttonId"=>"1",
			"buttonText"=>"⚜️ Panel de reservas",
			"url"=>"https://grupoeuroandino.com/app/render/reservas.php",
		))
);

// Convertir a JSON
$json_data = json_encode($data);

// Inicializar cURL
$ch = curl_init();

// Configurar opciones de cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'
));

// Ejecutar la petición
$response = curl_exec($ch);

// Verificar errores
/*if (curl_error($ch)) {
    echo 'Error cURL: ' . curl_error($ch);
} else {
    // Mostrar la respuesta
    echo 'Respuesta: ' . $response;
}*/

// Cerrar cURL
curl_close($ch);


?>
