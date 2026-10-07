<?php
/**
 * cifrado.php
 * ------------------------------------------------------------------
 * Cifrado / descifrado del correo del usuario con un "salt".
 * Usa AES-256-CBC con un IV aleatorio por cada cifrado; el IV viaja
 * prefijado dentro del token, que se codifica en base64url para poder
 * pasar por URL sin romperse.
 *
 * IMPORTANTE: cambia PANEL_SALT por un valor propio y mantenlo secreto.
 * ------------------------------------------------------------------
 */

require_once __DIR__ . '/env.php';

// Salt secreto del panel: se lee del archivo .env (nunca del código).
$panelSalt = panel_env('PANEL_SALT', '');
if ($panelSalt === null || $panelSalt === '') {
    die('Falta definir PANEL_SALT en el archivo .env del panel.');
}
define('PANEL_SALT', $panelSalt);
unset($panelSalt);

// Algoritmo de cifrado simétrico (configurable desde el .env).
define('PANEL_CIFRADO', panel_env('PANEL_CIFRADO', 'aes-256-cbc'));

/** Deriva la clave de 32 bytes (AES-256) a partir del salt. */
function panel_clave_cifrado(): string
{
    return hash('sha256', PANEL_SALT, true);
}

/** Cifra el correo y devuelve un token seguro para URL. */
function cifrarCorreo(string $correo): string
{
    $clave   = panel_clave_cifrado();
    $largoIv = openssl_cipher_iv_length(PANEL_CIFRADO);
    $iv      = random_bytes($largoIv);

    $cifrado = openssl_encrypt($correo, PANEL_CIFRADO, $clave, OPENSSL_RAW_DATA, $iv);
    if ($cifrado === false) {
        return '';
    }

    return rtrim(strtr(base64_encode($iv . $cifrado), '+/', '-_'), '=');
}

/** Descifra el token y devuelve el correo, o null si es inválido. */
function descifrarCorreo(string $token): ?string
{
    if ($token === '') {
        return null;
    }

    // Se restaura el base64 estándar (base64url -> base64) y su relleno.
    $token = strtr($token, '-_', '+/');
    $resto = strlen($token) % 4;
    if ($resto > 0) {
        $token .= str_repeat('=', 4 - $resto);
    }

    $bin = base64_decode($token, true);
    if ($bin === false) {
        return null;
    }

    $clave   = panel_clave_cifrado();
    $largoIv = openssl_cipher_iv_length(PANEL_CIFRADO);
    if (strlen($bin) <= $largoIv) {
        return null;
    }

    $iv      = substr($bin, 0, $largoIv);
    $cifrado = substr($bin, $largoIv);
    $correo  = openssl_decrypt($cifrado, PANEL_CIFRADO, $clave, OPENSSL_RAW_DATA, $iv);

    return ($correo === false || $correo === '') ? null : $correo;
}
