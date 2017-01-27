<?php
$server = '_SERVER';
$_SERVER; 
//print_r($_SERVER);
//if(array_key_exists('SERVER_PORT', $_SERVER) && $_SERVER["SERVER_PORT"] == 8008) {
if($_SERVER['SHELL'] == "/bin/bash" || $_SERVER['SERVER_PORT'] == "8008") {
	//echo "1-test";
	$dbuser = 'root';
	$dbpass = 'password';
}
//if($_SERVER['SERVER_PORT'] == 80) {
else {
	include("../../../config.inc.php");
	//echo "2-test";
	$dbuser =DB_USER;                    //sql connection username & password
	$dbpass =DB_PASSWORD;
}

$dbname ="waymessier_db";
$host = 'localhost';

?>

