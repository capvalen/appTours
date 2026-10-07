<?php
/**
 * google_login.php
 * ------------------------------------------------------------------
 * Recibe el ID Token de Firebase (login con Google), lo verifica en el
 * servidor y crea/recupera la cuenta en la tabla `cuentas`.
 *
 *   - Si la cuenta ya tiene nombres y apellidos -> dashboard
 *   - Si falta completar nombres/apellidos     -> completar_perfil.php
 *
 * Responde JSON: { ok: true, redirect: "..." }  |  { ok: false, error: "..." }
 * ------------------------------------------------------------------
 */
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/firebase_verificar.php';

header('Content-Type: application/json; charset=utf-8');

/** Responde JSON y termina. */
function responder(array $data, int $codigo = 200): void
{
    http_response_code($codigo);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        responder(['ok' => false, 'error' => 'Método no permitido.'], 405);
    }

    $idToken = $_POST['idToken'] ?? '';
    if (!is_string($idToken) || $idToken === '') {
        responder(['ok' => false, 'error' => 'No se recibió el token de Google.'], 400);
    }

    $config    = require __DIR__ . '/firebase_config.php';
    $projectId = $config['web']['projectId'] ?? '';
    if ($projectId === '' || $projectId === 'TU_PROYECTO') {
        responder(['ok' => false, 'error' => 'Firebase no está configurado todavía.'], 500);
    }

    // 1) Verificar el token
    $claims = firebase_verificar_id_token($idToken, $projectId);

    $correo = $claims['email'] ?? '';
    $uid    = $claims['sub']   ?? '';
    $foto   = $claims['picture'] ?? null;

    if ($correo === '') {
        responder(['ok' => false, 'error' => 'La cuenta de Google no tiene correo.'], 400);
    }

    // 2) Buscar la cuenta por google_uid o por correo
    $stmt = $db->prepare(
        'SELECT id, nombres, apellidos
         FROM cuentas
         WHERE google_uid = :uid OR correo = :correo
         LIMIT 1'
    );
    $stmt->execute([':uid' => $uid, ':correo' => $correo]);
    $cuenta = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cuenta) {
        $cuentaId = (int) $cuenta['id'];

        // Asociar la cuenta a Google (si aún no lo estaba) y actualizar la foto
        $upd = $db->prepare(
            'UPDATE cuentas
             SET google_uid = :uid,
                 foto       = COALESCE(:foto, foto),
                 proveedor  = "google"
             WHERE id = :id'
        );
        $upd->execute([':uid' => $uid, ':foto' => $foto, ':id' => $cuentaId]);

        $tieneNombres = trim((string) ($cuenta['nombres'] ?? '')) !== ''
                     && trim((string) ($cuenta['apellidos'] ?? '')) !== '';

        if ($tieneNombres) {
            $_SESSION['cuenta_id']        = $cuentaId;
            $_SESSION['cuenta_nombres']   = $cuenta['nombres'];
            $_SESSION['cuenta_apellidos'] = $cuenta['apellidos'];
            $_SESSION['cuenta_correo']    = $correo;
            unset($_SESSION['perfil_incompleto']);

            session_regenerate_id(true);
            responder(['ok' => true, 'redirect' => 'dashboard.php']);
        }

        // Existe pero le faltan nombres/apellidos
        $_SESSION['cuenta_id']           = $cuentaId;
        $_SESSION['cuenta_correo']       = $correo;
        $_SESSION['perfil_incompleto']   = true;

        session_regenerate_id(true);
        responder(['ok' => true, 'redirect' => 'completar_perfil.php']);
    }

    // 3) Cuenta nueva: se crea "provisional" (sin nombres/apellidos todavía)
    $ins = $db->prepare(
        'INSERT INTO cuentas (correo, google_uid, foto, proveedor, password, nombres, apellidos)
         VALUES (:correo, :uid, :foto, "google", NULL, NULL, NULL)'
    );
    $ins->execute([':correo' => $correo, ':uid' => $uid, ':foto' => $foto]);
    $nuevoId = (int) $db->lastInsertId();

    $_SESSION['cuenta_id']         = $nuevoId;
    $_SESSION['cuenta_correo']     = $correo;
    $_SESSION['perfil_incompleto'] = true;

    session_regenerate_id(true);
    responder(['ok' => true, 'redirect' => 'completar_perfil.php']);

} catch (Exception $e) {
    responder(['ok' => false, 'error' => $e->getMessage()], 400);
} catch (PDOException $e) {
    responder(['ok' => false, 'error' => 'Error al acceder a la base de datos.'], 500);
}
