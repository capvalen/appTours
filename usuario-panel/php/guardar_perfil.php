<?php
/**
 * guardar_perfil.php
 * ------------------------------------------------------------------
 * Guarda nombres y apellidos del usuario que entró con Google
 * (completa su perfil) y luego lo lleva al dashboard.
 * ------------------------------------------------------------------
 */
require_once __DIR__ . '/conexion.php';

if (empty($_SESSION['cuenta_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../completar_perfil.php');
    exit;
}

$apellidos = trim($_POST['apellidos'] ?? '');
$nombres   = trim($_POST['nombres']   ?? '');
$cuentaId  = (int) $_SESSION['cuenta_id'];

if ($apellidos === '' || $nombres === '') {
    $_SESSION['error_perfil'] = 'Debes ingresar tus apellidos y nombres.';
    header('Location: ../completar_perfil.php');
    exit;
}

try {
    $stmt = $db->prepare('UPDATE cuentas SET apellidos = :apellidos, nombres = :nombres WHERE id = :id');
    $stmt->execute([':apellidos' => $apellidos, ':nombres' => $nombres, ':id' => $cuentaId]);

    $_SESSION['cuenta_nombres']   = $nombres;
    $_SESSION['cuenta_apellidos'] = $apellidos;
    unset($_SESSION['perfil_incompleto'], $_SESSION['error_perfil']);

    header('Location: ../dashboard.php');
    exit;

} catch (PDOException $e) {
    $_SESSION['error_perfil'] = 'No se pudo guardar tu perfil. Inténtalo de nuevo.';
    header('Location: ../completar_perfil.php');
    exit;
}
