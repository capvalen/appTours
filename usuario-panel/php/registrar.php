<?php
/**
 * registrar.php
 * Procesa el formulario de "Registro de cuenta".
 */
require_once __DIR__ . '/conexion.php';

/** Devuelve al formulario guardando el error y los datos escritos. */
function volverConError(string $mensaje): void
{
    $_SESSION['error_registro'] = $mensaje;
    $_SESSION['old_registro'] = [
        'apellidos' => $_POST['apellidos'] ?? '',
        'nombres'   => $_POST['nombres']   ?? '',
        'correo'    => $_POST['correo']    ?? '',
    ];
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$apellidos = trim($_POST['apellidos'] ?? '');
$nombres   = trim($_POST['nombres']   ?? '');
$correo    = trim($_POST['correo']    ?? '');
$password  = $_POST['password']  ?? '';
$password2 = $_POST['password2'] ?? '';

// ---- Validaciones ----
if ($apellidos === '' || $nombres === '' || $correo === '' || $password === '') {
    volverConError('Todos los campos son obligatorios.');
}
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    volverConError('El correo no tiene un formato válido.');
}
if (strlen($password) < 6) {
    volverConError('La contraseña debe tener al menos 6 caracteres.');
}
if ($password !== $password2) {
    volverConError('Las contraseñas no coinciden.');
}

try {
    // ¿El correo ya está registrado?
    $stmt = $db->prepare('SELECT id FROM cuentas WHERE correo = :correo LIMIT 1');
    $stmt->execute([':correo' => $correo]);
    if ($stmt->fetch()) {
        volverConError('Ese correo ya está registrado.');
    }

    // Guardar la contraseña cifrada
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare(
        'INSERT INTO cuentas (apellidos, nombres, correo, password)
         VALUES (:apellidos, :nombres, :correo, :password)'
    );
    $stmt->execute([
        ':apellidos' => $apellidos,
        ':nombres'   => $nombres,
        ':correo'    => $correo,
        ':password'  => $hash,
    ]);

    // Iniciar sesión automáticamente
    session_regenerate_id(true);
    $_SESSION['cuenta_id']        = (int) $db->lastInsertId();
    $_SESSION['cuenta_nombres']   = $nombres;
    $_SESSION['cuenta_apellidos'] = $apellidos;
    $_SESSION['cuenta_correo']    = $correo;
    unset($_SESSION['perfil_incompleto']);

    header('Location: ../dashboard.php');
    exit;

} catch (PDOException $e) {
    volverConError('Ocurrió un error al crear la cuenta. Inténtalo de nuevo.');
}
