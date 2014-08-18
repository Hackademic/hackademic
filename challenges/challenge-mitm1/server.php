<?php

$data = file_get_contents("php://input");
if(empty($data)) {
	badRequest();
}

$xmlDocument = simplexml_load_string($data);
if(!isset($xmlDocument->licenseKey) || !isset($xmlDocument->firstName) || !isset($xmlDocument->lastName)) {
	badRequest();
}

function badRequest() {
	header('HTTP/1.1 400 Bad Request');
	exit('<h1>400 Bad Request</h1>');
}

?>
<?xml version="1.0" encoding="UTF-8"?>
<responseData>
	<ipAddress>80.45.62.122</ipAddress>
	<licenseKey>FAKE-LICE-NCEK-EY00</licenseKey>
	<validLicense>false</validLicense>
</responseData>
