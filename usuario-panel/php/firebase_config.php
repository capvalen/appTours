<?php
/**
 * firebase_config.php
 * ------------------------------------------------------------------
 * Credenciales del proyecto Firebase (app web).
 *
 * IMPORTANTE:
 *  - Esta configuración es PÚBLICA (así funciona Firebase en web).
 *    NO es un secreto y no pasa nada si se ve en el navegador.
 *  - Reemplaza cada valor "TU_..." por los que te da Firebase.
 *
 * Dónde obtenerlos:
 *  Firebase Console -> Configuración del proyecto (⚙️) -> Tus apps
 *  -> App web -> "Configuración del SDK" -> "Config".
 * ------------------------------------------------------------------
 */

return [
    'web' => [
        'apiKey'            => 'AIzaSyBpZHdZWQaMYT6QfP1R4fu_waR34bu4HRU',
        'authDomain'        => 'auth.grupoeuroandino.com',
        //'authDomain'        => 'deudores-2721d.firebaseapp.com',
				'databaseURL'       => "https://deudores-2721d-default-rtdb.firebaseio.com",
        'projectId'         => 'deudores-2721d',
        'storageBucket'     => 'deudores-2721d.appspot.com',
        'messagingSenderId' => '579051362956',
        'appId'             => '1:579051362956:web:e48b6a1c131287c8d6f9a9',
    ],
];
