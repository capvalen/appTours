<?php
$rutaImgs = "/home/perutra1/grupoeuroandino.com/app/render/images/subidas/";
$rutaLogos = "/home/perutra1/grupoeuroandino.com/app/render/images/";
$rutaMarca = "/home/perutra1/grupoeuroandino.com/app/render/images/marcas/";
$nombreArchivo = '62c17be5bb8e4.jpg';

$fondo = $rutaImgs.$nombreArchivo;
$logo = $rutaLogos.'gea.png';
$whatsapp = $rutaLogos.'whatsapp.png';

$rutaGuardado = $rutaMarca.$nombreArchivo;

// Crear imágenes desde los archivos
$imagenDeFondo = imagecreatefromjpeg($fondo);
$logo = imagecreatefrompng($logo);
$whatsapp = imagecreatefrompng($whatsapp);

// Redimensionar el logo 
$logo = imagescale($logo, 250, 250);
//$whatsapp = imagescale($whatsapp, 250, 129);

// Obtener dimensiones de las imágenes
$anchoFondo = imagesx($imagenDeFondo);
$altoFondo = imagesy($imagenDeFondo);
$anchoSuperpuesta = imagesx($logo);
$altoSuperpuesta = imagesy($logo);
$anchoWhats = imagesx($whatsapp);
$altoWhats = imagesy($whatsapp);

// Calcular la posición de la superposición
$posicionX = 20; // ajusta la posición X como desees
$posicionY = 20; // ajusta la posición Y como desees
$pX = $anchoFondo - $anchoWhats - 20;
$pY = 40;

// Fusionar las imágenes
imagecopy($imagenDeFondo, $logo, $posicionX, $posicionY, 0, 0, $anchoSuperpuesta, $altoSuperpuesta);
imagecopy($imagenDeFondo, $whatsapp, $pX, $pY, 0, 0, $anchoWhats, $altoWhats);
// Guardar la imagen fusionada en un directorio
imagejpeg($imagenDeFondo, $rutaMarca. $nombreArchivo);
echo 'Imágen creada en '.$rutaMarca. $nombreArchivo;

// Liberar memoria
imagedestroy($imagenDeFondo);
imagedestroy($logo);
?>