<?php

// Includes the PHP library for RSA:
set_include_path(get_include_path().PATH_SEPARATOR .'phpseclib');
include('Crypt/RSA.php');

$data = file_get_contents("php://input");
if(empty($data)) {
	badRequest();
}

$xmlDocument = simplexml_load_string($data);
if(!isset($xmlDocument->publicKeyB64) || !isset($xmlDocument->licenseKey) || 
	!isset($xmlDocument->firstName) || !isset($xmlDocument->lastName)) {
	badRequest();
}

// Decodes the public key.
$publicKey = base64_decode($xmlDocument->publicKeyB64);

// Encrypts the XML response:
$xml = '<responseData>
	<publicIpAddress>80.45.62.122</publicIpAddress>
	<licenseKey>FAKE-LICE-NCEK-EY00</licenseKey>
	<validLicense>false</validLicense>
</responseData>';
$rsa = new Crypt_RSA();
$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
$rsa->loadKey($publicKey);
$encrypted = base64_encode($rsa->encrypt($xml));

function badRequest() {
	header('HTTP/1.1 400 Bad Request');
	exit('<h1>400 Bad Request</h1>');
}

?>
<?xml version="1.0" encoding="UTF-8"?>
<responseData>
	<encryptedData><?= $encrypted ?></encryptedData>
</responseData>
