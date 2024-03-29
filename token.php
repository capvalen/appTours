<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/lyracom/rest-php-sdk/src/autoload.php';



/* Username, password and endpoint used for server to server web-service calls */
//(En el Back Office) Copiar Usuario
Lyra\Client::setDefaultUsername("99809654");
//(En el Back Office) Copiar Contraseña de test
Lyra\Client::setDefaultPassword("prodpassword_tizeTz2QPzQJPvT4VOFxDOZu8fPQw2SBb5qy8Z5rlf0Bc");
//(En el Back Office) Copiar Contraseña de Nombre del servidor API REST
Lyra\Client::setDefaultEndpoint("https://api.micuentaweb.pe");

/* publicKey and used by the javascript client */
//(En el Back Office) Copiar Clave pública de test
Lyra\Client::setDefaultPublicKey("99809654:publickey_tXwOD7MbbajQWgNUXaUU1UaIrlEqLFpESM2tz7weDTqNI");

/* SHA256 key */
//(En el Back Office) Clave HMAC-SHA-256 de test
Lyra\Client::setDefaultSHA256Key("Wz5psTWkPWJwOsHuq2E1X289f1JH0kVBaEUhz92KXmnV2");


/** 
 * Initialize the SDK 
 * see keys.php
 */
$client = new Lyra\Client();


/**
 * starting to create a transaction
 */
$store = array(
  "amount" => $_POST['monto'], 
  "currency" => "PEN",
  "customer" => array(
    "email" => $_POST['correo'],
  ),
  "orderId" => $_POST['id']
);

/**
 * do the web-service call
 */
$response = $client->post("V4/Charge/CreatePayment", $store);

/* I check if there are some errors */
if ($response['status'] != 'SUCCESS') {
  /* an error occurs, I throw an exception */
  #display_errors($response);
  $error = $response['answer'];
  throw new Exception("error " . $error['errorCode'] . ": " . $error['errorMessage'] );
}

/* everything is fine, I extract the formToken */
$formToken = $response["answer"]["formToken"];

echo $formToken;


?>