<?php
$input = file_get_contents('php://input');
$datos = json_decode($input, true);

$destinatario = "grupoeuroandino@hotmail.com";
$asunto = "Cliente interesado";
$mensaje = "
<html>
<head>
  <title>Cliente interesado</title>
</head>
<body>
  <p>Hemos detectado que este cliente puede estar interesado!</p>
  <p><b>Nombre:</b> {$datos['nombre']}</p>
  <p><b>Dni:</b> {$datos['dni']}</p>
  <p><b>Celular:</b> {$datos['celular']}</p>
  <p><b>Correo:</b> {$datos['correo']}</p>
</body>
</html>
";

// Cabeceras para email HTML
$cabeceras = "MIME-Version: 1.0" . "\r\n";
$cabeceras .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$cabeceras .= "From: Grupo Euro Andino <facturas@grupoeuroandino.com>" . "\r\n";

// Enviar el email
if(mail($destinatario, $asunto, $mensaje, $cabeceras)) {
    echo "Email enviado correctamente";
} else {
    echo "Error al enviar el email";
}
?>