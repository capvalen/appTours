<?php
/**
 * firebase_verificar.php
 * ------------------------------------------------------------------
 * Verifica (en el servidor) un ID Token de Firebase Auth SIN
 * dependencias externas: descarga las claves públicas de Google y
 * valida la firma RS256 + los claims estándar (aud, iss, exp, sub).
 * ------------------------------------------------------------------
 */

/** Decodifica un segmento base64url. */
function fb_base64url_decode(string $data): string
{
    $resto = strlen($data) % 4;
    if ($resto) {
        $data .= str_repeat('=', 4 - $resto);
    }
    return base64_decode(strtr($data, '-_', '+/')) ?: '';
}

/**
 * Obtiene los certificados públicos de Google (cache 1 hora).
 * @return array<string,string> kid => certificado PEM
 */
function fb_obtener_certs_google(): array
{
    $url       = 'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com';
    $cacheFile = sys_get_temp_dir() . '/fb_securetoken_certs.json';

    if (is_file($cacheFile) && (time() - filemtime($cacheFile) < 3600)) {
        $cache = json_decode((string) file_get_contents($cacheFile), true);
        if (is_array($cache) && $cache) {
            return $cache;
        }
    }

    $raw = null;
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        $raw = curl_exec($ch);
        curl_close($ch);
    } else {
        $ctx = stream_context_create(['http' => ['timeout' => 10]]);
        $raw = @file_get_contents($url, false, $ctx);
    }

    $certs = is_string($raw) ? json_decode($raw, true) : null;
    if (is_array($certs) && $certs) {
        @file_put_contents($cacheFile, (string) $raw);
        return $certs;
    }

    // Si falla la red pero hay cache vieja, se usa igual.
    if (is_file($cacheFile)) {
        $cache = json_decode((string) file_get_contents($cacheFile), true);
        if (is_array($cache) && $cache) {
            return $cache;
        }
    }

    throw new Exception('No se pudieron obtener las claves públicas de Google.');
}

/**
 * Verifica un ID Token de Firebase y devuelve sus claims.
 *
 * @throws Exception si el token es inválido.
 * @return array claims (email, sub, name, picture, ...)
 */
function firebase_verificar_id_token(string $idToken, string $projectId): array
{
    $partes = explode('.', $idToken);
    if (count($partes) !== 3) {
        throw new Exception('Token mal formado.');
    }
    [$h64, $p64, $s64] = $partes;

    $header  = json_decode(fb_base64url_decode($h64), true);
    $payload = json_decode(fb_base64url_decode($p64), true);

    if (!is_array($header) || !is_array($payload)) {
        throw new Exception('Token inválido.');
    }
    if (($header['alg'] ?? '') !== 'RS256' || empty($header['kid'])) {
        throw new Exception('Algoritmo de firma no soportado.');
    }

    $certs = fb_obtener_certs_google();
    if (empty($certs[$header['kid']])) {
        throw new Exception('No se encontró la clave para verificar la firma.');
    }

    $firma = fb_base64url_decode($s64);
    $ok    = openssl_verify($h64 . '.' . $p64, $firma, $certs[$header['kid']], OPENSSL_ALGO_SHA256);
    if ($ok !== 1) {
        throw new Exception('La firma del token no es válida.');
    }

    $ahora = time();
    if ((int) ($payload['exp'] ?? 0) < $ahora) {
        throw new Exception('El token ha expirado.');
    }
    if ((int) ($payload['iat'] ?? 0) > $ahora + 300) {
        throw new Exception('El token aún no es válido.');
    }
    if (($payload['aud'] ?? '') !== $projectId) {
        throw new Exception('El token no pertenece a este proyecto.');
    }
    if (($payload['iss'] ?? '') !== 'https://securetoken.google.com/' . $projectId) {
        throw new Exception('El emisor del token no es válido.');
    }
    if (empty($payload['sub'])) {
        throw new Exception('El token no tiene sujeto (sub).');
    }

    return $payload;
}
