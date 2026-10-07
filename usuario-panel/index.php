<?php
/**
 * index.php  ->  Registro de cuenta
 */
require_once __DIR__ . '/php/conexion.php';

// Si ya hay sesión, ir directo al dashboard (o a completar perfil)
if (!empty($_SESSION['cuenta_id'])) {
    header('Location: ' . (empty($_SESSION['perfil_incompleto']) ? 'dashboard.php' : 'completar_perfil.php'));
    exit;
}

$firebaseConfig = require __DIR__ . '/php/firebase_config.php';

$error = $_SESSION['error_registro'] ?? null;
$old   = $_SESSION['old_registro'] ?? ['apellidos' => '', 'nombres' => '', 'correo' => ''];
unset($_SESSION['error_registro'], $_SESSION['old_registro']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de cuenta</title>
    <link rel="icon" href="https://grupoeuroandino.com/wp-content/uploads/2023/07/cropped-Grupo-Euro-Andino-favicon-32x32.png" sizes="32x32" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css?v=5">

    <!-- Firebase (login con Google) -->
    <script>window.FIREBASE_CONFIG = <?= json_encode($firebaseConfig['web'], JSON_UNESCAPED_SLASHES) ?>;</script>
    <script type="module" src="assets/js/auth-google.js"></script>
</head>
<body class="fondo-auth">
    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
        <div class="card card-auth w-100" style="max-width: 520px;">
            <div class="card-body p-4 p-md-5">

                <!-- Cabecera: título + link a login -->
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icono-auth"><i class="bi bi-person-plus"></i></div>
                        <h1 class="h4 fw-bold mb-0">Registro de cuenta</h1>
                    </div>
                    <span class="small text-muted pt-1">
                        ¿Ya tienes tu cuenta?
                        <a href="https://grupoeuroandino.com/login-panel/" target="_top" class="fw-semibold text-decoration-none">Inicia sesión</a>
                    </span>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger d-flex align-items-center gap-2 py-2" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div><?= htmlspecialchars($error) ?></div>
                    </div>
                <?php endif; ?>

                <form action="php/registrar.php" method="post" autocomplete="off">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos"
                                   value="<?= htmlspecialchars($old['apellidos']) ?>" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres"
                                   value="<?= htmlspecialchars($old['nombres']) ?>" required>
                        </div>
                        <div class="col-12">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo"
                                   placeholder="tucorreo@ejemplo.com"
                                   value="<?= htmlspecialchars($old['correo']) ?>" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="password2" class="form-label">Repite la contraseña</label>
                            <input type="password" class="form-control" id="password2" name="password2" required>
                        </div>
                    </div>


                <div class="divisor-o">o</div>

                <div id="googleError" class="alert alert-danger d-none py-2" role="alert"></div>

                <button type="button" class="btn btn-google w-100" data-google-login>
                    <svg width="20" height="20" viewBox="0 0 48 48" aria-hidden="true">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                    </svg>
                    Continuar con Google
                </button>
                    <button type="submit" class="btn btn-primary w-100 mt-4">
                        <i class="bi bi-person-check me-1"></i> Crear cuenta
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
