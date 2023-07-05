<?php
// Ruta de la carpeta que contiene las imágenes
$directorio = '/home/perutra1/grupoeuroandino.com/app/render/images/subidas/';

// Obtener todas las imágenes en la carpeta
$archivos = glob($directorio . '*.{jpg,jpeg,png}', GLOB_BRACE);

// Tamaño deseado para las imágenes redimensionadas
$nuevoAncho = 530;
$nuevoAlto = 345;

// Iterar sobre cada imagen y redimensionarla
foreach ($archivos as $archivo) {
		// Obtener las dimensiones originales de la imagen
		list($ancho, $alto) = getimagesize($archivo);

		// Crear una imagen en blanco con las nuevas dimensiones
		$imagenRedimensionada = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

		// Cargar la imagen original según su tipo (JPEG, PNG, GIF)
		$tipo = exif_imagetype($archivo);
		switch ($tipo) {
				case IMAGETYPE_JPEG:
						$imagenOriginal = imagecreatefromjpeg($archivo);
						break;
				case IMAGETYPE_PNG:
						$imagenOriginal = imagecreatefrompng($archivo);
						break;
						break;
				default:
						// No es un tipo de imagen compatible, pasar a la siguiente imagen
						continue 2;
		}

		// Redimensionar la imagen original a las nuevas dimensiones
		imagecopyresampled(
				$imagenRedimensionada, $imagenOriginal,
				0, 0, 0, 0,
				$nuevoAncho, $nuevoAlto, $ancho, $alto
		);

		// Generar el nuevo nombre de archivo con "_mini" agregado
		$nombreOriginal = pathinfo($archivo, PATHINFO_FILENAME);
		$extension = pathinfo($archivo, PATHINFO_EXTENSION);
		$nuevoNombre = "small-".$nombreOriginal . '.' . $extension;

		// Guardar la imagen redimensionada en un nuevo archivo (en la misma carpeta)
		$nuevoArchivo = $directorio . $nuevoNombre;
		imagejpeg($imagenRedimensionada, $nuevoArchivo, 100);

		// Liberar memoria
		imagedestroy($imagenOriginal);
		imagedestroy($imagenRedimensionada);

		echo "La imagen $archivo se ha redimensionado con éxito y se ha guardado como $nuevoNombre.<br>";
}
?>