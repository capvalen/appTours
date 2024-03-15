<?php
$rutaImgs = "/home/perutra1/grupoeuroandino.com/app/render/images/subidas/";
$rutaLogos = "/home/perutra1/grupoeuroandino.com/app/render/images/";
$rutaMarca = "/home/perutra1/grupoeuroandino.com/app/render/images/marcas/";
$nombreArchivo = '6256f16f2c783.png';

$fondo = $rutaImgs.$nombreArchivo;
$logo = $rutaLogos.'gea.png';
$whatsapp = $rutaLogos.'whatsapp.png';

$rutaGuardado = $rutaMarca.$nombreArchivo;
$tipoImagen = obtenerTipoImagen($fondo);


// Crear imágenes desde los archivos
if ($tipoImagen === IMAGETYPE_JPEG)  $imagenDeFondo = imagecreatefromjpeg($fondo);
if ($tipoImagen === IMAGETYPE_PNG)  $imagenDeFondo = imagecreatefrompng($fondo);
$logo = imagecreatefrompng($logo);
$whatsapp = imagecreatefrompng($whatsapp);

// Obtener dimensiones de las imágenes
$anchoFondo = imagesx($imagenDeFondo);
$altoFondo = imagesy($imagenDeFondo);

// Redimensionar el logo 
$logo = imagescale($logo, $anchoFondo*0.115, $anchoFondo*0.115);
$whatsapp = imagescale($whatsapp, $anchoFondo*0.18, -1);
//$whatsapp = imagescale($whatsapp, 250, 129);

$anchoSuperpuesta = imagesx($logo);
$altoSuperpuesta = imagesy($logo);
$anchoWhats = imagesx($whatsapp);
$altoWhats = imagesy($whatsapp);

// Calcular la posición de la superposición
$posicionX = $anchoFondo*0.063; // ajusta la posición X como desees
$posicionY = $posicionX; // ajusta la posición Y como desees
$pX = $anchoFondo - $anchoWhats -$posicionX;
$pY = $posicionY;

echo 'total '.$anchoFondo."<br>";
echo 'posx '.$posicionX."<br>";
// Fusionar las imágenes
imagecopy($imagenDeFondo, $logo, $posicionX, $posicionY, 0, 0, $anchoSuperpuesta, $altoSuperpuesta);
imagecopy($imagenDeFondo, $whatsapp, $pX, $pY, 0, 0, $anchoWhats, $altoWhats);

// Guardar la imagen fusionada en un directorio
if ($tipoImagen === IMAGETYPE_JPEG) imagejpeg($imagenDeFondo, $rutaMarca. $nombreArchivo);
if ($tipoImagen === IMAGETYPE_PNG) imagepng($imagenDeFondo, $rutaMarca. $nombreArchivo);

echo 'Imágen creada en '.$rutaMarca. $nombreArchivo;

// Liberar memoria
imagedestroy($imagenDeFondo);
imagedestroy($logo);

function obtenerTipoImagen($imagen) {
  $info = getimagesize($imagen);
  if ($info === false) {
    return false;
  }
  return $info[2];
}
?>