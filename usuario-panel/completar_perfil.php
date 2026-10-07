<?php
/**
 * completar_perfil.php
 * ------------------------------------------------------------------
 * Obligatorio para quienes ingresan con Google: antes de ir al
 * dashboard deben registrar sus apellidos y nombres.
 * ------------------------------------------------------------------
 */
require_once __DIR__ . '/php/conexion.php';

// Debe haber una sesión iniciada
if (empty($_SESSION['cuenta_id'])) {
    header('Location: login.php');
    exit;
}

// Si el perfil ya está completo, no tiene sentido estar aquí
if (empty($_SESSION['perfil_incompleto'])) {
    header('Location: dashboard.php');
    exit;
}

$error  = $_SESSION['error_perfil'] ?? null;
$correo = $_SESSION['cuenta_correo'] ?? '';
unset($_SESSION['error_perfil']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completa tu perfil</title>
    <link rel="icon" href="https://grupoeuroandino.com/wp-content/uploads/2023/07/cropped-Grupo-Euro-Andino-favicon-32x32.png" sizes="32x32" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css?v=5">
</head>
<body class="fondo-auth">
    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
        <div class="card card-auth w-100" style="max-width: 520px;">
            <div class="card-body p-4 p-md-5">

                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="icono-auth"><i class="bi bi-person-vcard"></i></div>
                    <h1 class="h4 fw-bold mb-0">Completa tu perfil</h1>
                </div>
                <p class="text-muted mb-4">
                    Ingresaste con Google (<strong><?= htmlspecialchars($correo) ?></strong>).
                    Antes de continuar necesitamos tus apellidos y nombres.
                </p>

                <?php if ($error): ?>
                    <div class="alert alert-danger d-flex align-items-center gap-2 py-2" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div><?= htmlspecialchars($error) ?></div>
                    </div>
                <?php endif; ?>

                <form action="php/guardar_perfil.php" method="post" autocomplete="off">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-4">
                        <i class="bi bi-check2-circle me-1"></i> Guardar y continuar
                    </button>
                </form>

                <p class="text-center small text-muted mt-3 mb-0">
                    <a href="php/cerrar_sesion.php" class="text-decoration-none">Cerrar sesión</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
