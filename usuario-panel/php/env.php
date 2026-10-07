<?php
/**
 * env.php
 * ------------------------------------------------------------------
 * Cargador mínimo de variables de entorno desde un archivo .env.
 * No usa dependencias externas (no hay vlucas/phpdotenv instalado).
 *
 * Busca el .env, en este orden:
 *   usuario-panel/.env        (junto al panel)
 *   <raíz del proyecto>/.env  (un nivel arriba de usuario-panel)
 * ------------------------------------------------------------------
 */

/** Devuelve el valor de una variable del .env (o del entorno real). */
function panel_env(string $clave, ?string $porDefecto = null): ?string
{
    panel_env_cargar();

    $valor = $_ENV[$clave] ?? getenv($clave);
    if ($valor === false || $valor === null || $valor === '') {
        return $porDefecto;
    }

    return (string) $valor;
}

/** Carga el primer archivo .env que encuentre (una sola vez). */
function panel_env_cargar(): void
{
    static $yaCargado = false;
    if ($yaCargado) {
        return;
    }
    $yaCargado = true;

    $rutas = [
        __DIR__ . '/../.env',     // usuario-panel/.env
        __DIR__ . '/../../.env',  // <raíz>/.env
    ];

    foreach ($rutas as $ruta) {
        if (is_file($ruta) && is_readable($ruta)) {
            panel_env_parsear($ruta);
            return;
        }
    }
}

/** Parsea un archivo .env y define las variables en el entorno. */
function panel_env_parsear(string $ruta): void
{
    $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lineas === false) {
        return;
    }

    foreach ($lineas as $linea) {
        $linea = trim($linea);
        if ($linea === '' || $linea[0] === '#') {
            continue;
        }

        // Permite el prefijo opcional "export CLAVE=valor"
        if (stripos($linea, 'export ') === 0) {
            $linea = trim(substr($linea, 7));
        }

        $pos = strpos($linea, '=');
        if ($pos === false) {
            continue;
        }

        $clave = trim(substr($linea, 0, $pos));
        $valor = trim(substr($linea, $pos + 1));

        // Quita las comillas que envuelven el valor
        $largo = strlen($valor);
        if ($largo >= 2) {
            $primero = $valor[0];
            $ultimo  = $valor[$largo - 1];
            if (($primero === '"' && $ultimo === '"') || ($primero === "'" && $ultimo === "'")) {
                $valor = substr($valor, 1, -1);
            }
        }

        if ($clave === '') {
            continue;
        }

        // No sobreescribe variables ya definidas en el entorno real
        if (getenv($clave) !== false) {
            continue;
        }

        $_ENV[$clave]    = $valor;
        $_SERVER[$clave] = $valor;
        putenv($clave . '=' . $valor);
    }
}
