<?php

session_start();

$data = file_get_contents("php://input");
if(!empty($data)) {
	$_SESSION['validLicense'] = 'false';
	$xmlDocument = simplexml_load_string($data);
	if(!isset($xmlDocument->validLicense) || !isset($xmlDocument->ipAddress) || !isset($xmlDocument->licenseKey)) {
		exit('Application refuses to open!');
	}
	if($xmlDocument->validLicense == 'true') {
		$_SESSION['validLicense'] = 'true';
		exit('Application opened!');
	}
	exit('Application refuses to open!');
}

?>
<?xml version="1.0" encoding="UTF-8"?>
<responseData>
	<firstName>John</firstName>
	<lastName>Smith</lastName>
	<licenseKey>FAKE-LICE-NCEK-EY00</licenseKey>
</responseData>
