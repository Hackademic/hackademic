<?php

// Includes and starts the PHP library for RSA:
set_include_path(get_include_path().PATH_SEPARATOR .'phpseclib');
include('Crypt/RSA.php');
$rsa = new Crypt_RSA();
$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);

session_start();

$encryptedData = file_get_contents("php://input");
if(!empty($encryptedData)) {
// Received the response from the server.
	$_SESSION['validLicense'] = 'false';

	$encryptedXmlDocument = simplexml_load_string($encryptedData);
	if(!isset($encryptedXmlDocument->encryptedData)) {
		exit('Application refuses to open!');
	}

	// Decrypts the XML response:
	$rsa->loadKey($_SESSION['private_key']);
	$data = $rsa->decrypt(base64_decode($encryptedXmlDocument->encryptedData));
	$xmlDocument = simplexml_load_string($data);

	if(!isset($xmlDocument->validLicense) || !isset($xmlDocument->publicIpAddress) || !isset($xmlDocument->licenseKey)) {
		exit('Application refuses to open!');
	}
	if($xmlDocument->validLicense == 'true') {
		$_SESSION['validLicense'] = 'true';
		exit('Application opened!');
	}
	exit('Application refuses to open!');
}

// If we reach this points it means that we must send a request to the server.
// Generates the public and private keys:
$keys = $rsa->createKey();
$_SESSION['public_key'] = $keys['publickey'];
$_SESSION['private_key'] = $keys['privatekey'];

?>
<?xml version="1.0" encoding="UTF-8"?>
<responseData>
	<firstName>John</firstName>
	<lastName>Smith</lastName>
	<licenseKey>FAKE-LICE-NCEK-EY00</licenseKey>
	<publicKeyB64><?= base64_encode($_SESSION['public_key']) ?></publicKeyB64>
</responseData>
