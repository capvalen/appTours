<?php
/**
 * verPedidos.php  (usuario-panel)
 * ------------------------------------------------------------------
 * Devuelve los pedidos de un usuario (sin pagar = idEstado 1 y
 * pagadas = idEstado 2) buscando por su campo `correo`.
 *
 * El correo NUNCA viaja en claro: se recibe cifrado con salt
 * (ver cifrado.php) y aquí se descifra para hacer la búsqueda.
 *
 * Formas de uso:
 *   - Incluido desde dashboard.php:
 *       define('PANEL_INCLUYE_VERPEDIDOS', true);
 *       $correoCifrado = cifrarCorreo($correo);
 *       require __DIR__ . '/php/verPedidos.php';
 *     Al terminar quedan disponibles $pedidos y $errorPedidos.
 *   - Acceso directo por HTTP:  verPedidos.php?correo=<token>
 *     Responde JSON con el listado.
 * ------------------------------------------------------------------
 */
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/cifrado.php';

$esAccesoDirecto = !defined('PANEL_INCLUYE_VERPEDIDOS');

// Token cifrado: por variable (include) o por GET (acceso directo HTTP).
$token = $correoCifrado ?? ($_GET['correo'] ?? '');

$pedidos      = [];
$errorPedidos = null;

$correo = descifrarCorreo((string) $token);

if ($correo === null || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errorPedidos = 'No se pudo identificar al usuario.';
} else {
    try {
        $stmt = $db->prepare(
            'SELECT p.*, e.estado, t.url
             FROM pedidos p
             INNER JOIN estados e ON e.id = p.idEstado
             INNER JOIN tours   t ON t.id = p.idTour
             WHERE LOWER(p.correo) = LOWER(:correo)
               AND p.idEstado IN (1, 2)
               AND p.activo    = 1
             ORDER BY p.fecha DESC
             LIMIT 50'
        );
        $stmt->execute([':correo' => $correo]);
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $errorPedidos = 'No se pudieron cargar tus compras.';
    }
}

// Si se accedió directo por HTTP, se responde en JSON.
if ($esAccesoDirecto) {
    header('Content-Type: application/json; charset=utf-8');
    if ($errorPedidos !== null) {
        echo json_encode(['ok' => false, 'error' => $errorPedidos], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode($pedidos, JSON_UNESCAPED_UNICODE);
    }
    exit;
}
