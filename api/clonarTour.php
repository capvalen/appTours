<?php 
/* ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1); */

include ("conectkarl.php");
$_POST = json_decode(file_get_contents('php://input'),true);

( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )? die() : '';


$sql =$db->prepare("INSERT INTO `tours` (`contenido`, `visible`, `activo`, `url`, `tipo`, `pais` )
SELECT `contenido`, `visible`, `activo`, concat(`url`, '-1'), `tipo`, `pais` from tours
WHERE `id` = ?; ");
$resp = $sql->execute([ $_POST['id'] ]);
$nuevo_id = $db->lastInsertId();

$sql = $db->prepare("UPDATE tours 
	SET contenido = JSON_SET(contenido,
	'$.fotos', '',
	'$.url', url
	)	
	WHERE id = ?");
$resp = $sql->execute([$nuevo_id]);
//copiarConNombreAleatorio($fotos);

if($resp){
	echo 'ok';
}else{
	echo $sql->debugDumpParams();
	echo $sql->errorinfo();
}

function copiarConNombreAleatorio($archivos) {
    $resultados = [];
    
    foreach ($archivos as $archivoOriginal) {
        $archivoOriginal = trim($archivoOriginal);
        
        // Verificar si el archivo existe
        if (!file_exists($archivoOriginal)) {
            $resultados[$archivoOriginal] = "Error: Archivo no existe";
            continue;
        }
        
        // Obtener la extensión del archivo original
        $extension = pathinfo($archivoOriginal, PATHINFO_EXTENSION);
        
        // Generar nombre aleatorio similar al de PHP
        $nombreAleatorio = uniqid() . '.' . $extension;
        
        // Copiar el archivo
        if (copy($archivoOriginal, $nombreAleatorio)) {
            $resultados[$archivoOriginal] = [
                'nuevo_nombre' => $nombreAleatorio,
                'estado' => 'copiado'
            ];
        } else {
            $resultados[$archivoOriginal] = "Error al copiar";
        }
    }
    
    return $resultados;
}

?>