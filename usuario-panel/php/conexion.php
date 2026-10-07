<?php
/**
 * conexion.php
 * ------------------------------------------------------------------
 * Reutiliza la conexión del proyecto (api/conectkarl.php) y deja
 * disponible la variable $db (PDO) para el panel de usuario.
 * ------------------------------------------------------------------
 */

// Sesión (debe iniciarse antes de cualquier salida)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Se buscan rutas posibles para conectar con el archivo del proyecto.
// Desde  usuario-panel/php/  ->  appTours/api/conectkarl.php  (un nivel arriba de usuario-panel)
$rutasConectkarl = [
    __DIR__ . '/../../api/conectkarl.php',
    __DIR__ . '/../api/conectkarl.php',
    __DIR__ . '/../../conectkarl.php',
];

$rutaEncontrada = null;
foreach ($rutasConectkarl as $ruta) {
    if (is_file($ruta)) {
        $rutaEncontrada = $ruta;
        break;
    }
}

if ($rutaEncontrada === null) {
    die('No se encontró el archivo de conexión conectkarl.php');
}

// conectkarl.php define: $cadena (mysqli), $db (PDO), $esclavo, etc.
require_once $rutaEncontrada;

if (!isset($db) || !($db instanceof PDO)) {
    die('No se pudo establecer la conexión con la base de datos.');
}
