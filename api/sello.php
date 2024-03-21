<?php
require  "addLogo.php";

// Directorio a recorrer
$directorioSinMarca = '/home/perutra1/grupoeuroandino.com/app/render/images/sinmarca/';

// Abrir el directorio
$archivos = scandir($directorioSinMarca);

// Leer cada archivo del directorio
for ($i = 0; $i < count($archivos); $i++) {

  // Ignorar . y ..
  if ($archivos[$i] === '.' || $archivos[$i] === '..') {
    continue;
  }

	$_POST['nombreArchivo'] = $archivos[$i];
	//ob_start();
	addLogo();
	//ob_end_clean();
  // Procesar el archivo
  echo "Nombre del archivo: {$archivos[$i]}\n<br/>";

}

?>