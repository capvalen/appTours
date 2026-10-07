<?php
/**
 * validar_login.php
 * ------------------------------------------------------------------
 * NUEVO validador de inicio de sesión para el panel de usuario.
 * Valida correo + contraseña contra la tabla `cuentas` y, si es
 * correcto, redirige al dashboard.
 * ------------------------------------------------------------------
 */
require_once __DIR__ . '/conexion.php';

/** Devuelve al login con un mensaje de error. */
function volverConError(string $mensaje): void
{
    $_SESSION['error_login'] = $mensaje;
    $_SESSION['old_login']   = ['correo' => $_POST['correo'] ?? ''];
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

$correo   = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';

if ($correo === '' || $password === '') {
    volverConError('Ingresa tu correo y tu contraseña.');
}

try {
    $stmt = $db->prepare(
        'SELECT id, nombres, apellidos, correo, password, activo
         FROM cuentas
         WHERE correo = :correo
         LIMIT 1'
    );
    $stmt->execute([':correo' => $correo]);
    $cuenta = $stmt->fetch(PDO::FETCH_ASSOC);

    // Cuenta creada con Google (no tiene contraseña local)
    if ($cuenta && empty($cuenta['password'])) {
        volverConError('Esta cuenta se creó con Google. Usa "Continuar con Google".');
    }

    // No existe o la contraseña no coincide
    if (!$cuenta || !password_verify($password, (string) $cuenta['password'])) {
        volverConError('Correo o contraseña incorrectos.');
    }

    if ((int) $cuenta['activo'] !== 1) {
        volverConError('Tu cuenta está deshabilitada.');
    }

    // Acceso concedido -> se crea la sesión
    session_regenerate_id(true);
    $_SESSION['cuenta_id']        = (int) $cuenta['id'];
    $_SESSION['cuenta_nombres']   = $cuenta['nombres'];
    $_SESSION['cuenta_apellidos'] = $cuenta['apellidos'];
    $_SESSION['cuenta_correo']    = $cuenta['correo'];
    unset($_SESSION['perfil_incompleto']);

    header('Location: ../dashboard.php');
    exit;

} catch (PDOException $e) {
    volverConError('Ocurrió un error al iniciar sesión. Inténtalo de nuevo.');
}
