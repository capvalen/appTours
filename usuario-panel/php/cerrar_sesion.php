<?php
/**
 * cerrar_sesion.php
 * Destruye la sesión del usuario y regresa al login.
 */
require_once __DIR__ . '/conexion.php';

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $p['path'],
        $p['domain'],
        $p['secure'],
        $p['httponly']
    );
}

session_destroy();

header('Location: ../login.php');
exit;
