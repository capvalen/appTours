<?php 
$directorio = $_POST['ruta'];
$final ="/home/perutra1/grupoeuroandino.com/app/render/images/subidas/";

$tipoArchivo = strtolower(pathinfo( $directorio . basename($_FILES["archivo"]["name"]) ,PATHINFO_EXTENSION));
$queArchivo = uniqid() . "." . $tipoArchivo;
$archivoFinal = $directorio . $queArchivo; //basename($_FILES["archivo"]["name"]);
$previewFinal = $final ."small-". $queArchivo; //basename($_FILES["archivo"]["name"]);

if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivoFinal)) {
	//echo "The file ". htmlspecialchars( basename( $_FILES["archivo"]["name"])). " has been uploaded.";


	$archivoTemporal = "/home/perutra1/grupoeuroandino.com/app/render/images/sinmarca/". $queArchivo;

	// Cargar la imagen usando GD
	$imagen = imagecreatefromstring(file_get_contents($archivoTemporal));
	// Obtener las dimensiones actuales de la imagen
	$anchoOriginal = imagesx($imagen);
	$altoOriginal = imagesy($imagen);

	// Definir las nuevas dimensiones
	$nuevoAncho = 530;
	$nuevoAlto = 345;

	// Crear una nueva imagen con las dimensiones deseadas
	$nuevaImagen = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
	// Redimensionar la imagen original a la nueva imagen
	imagecopyresampled(
		$nuevaImagen, // Imagen de destino
		$imagen, // Imagen original
		0, 0, // Coordenadas de destino (esquina superior izquierda)
		0, 0, // Coordenadas de origen (esquina superior izquierda)
		$nuevoAncho, $nuevoAlto, // Dimensiones de destino
		$anchoOriginal, $altoOriginal // Dimensiones originales
	);

	// Guardar la nueva imagen en el directorio final
	imagejpeg($nuevaImagen, $previewFinal);
	// Liberar memoria
	imagedestroy($imagen);
	imagedestroy($nuevaImagen);

	//echo $archivoTemporal;
	$_POST['nombreArchivo'] = $queArchivo;
	ob_start();
	require "addLogo.php";
	ob_end_clean();
	echo $queArchivo;
} else {
	echo "Error subida".$_FILES["file"]["error"];
}