<?php

/**
 *    ----------------------------------------------------------------
 *    OWASP Hackademic Challenges Project
 *    ----------------------------------------------------------------
 *    Copyright (C) 2010-2011
 *   	  Andreas Venieris [venieris@owasp.gr]
 *   	  Anastasios Stasinopoulos [anast@owasp.gr]
 *    ----------------------------------------------------------------
 */

?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1253">
<title>Challenge 005</title>
<style type="text/css">
.style2 {
	font-size: xx-large;
	color: #0000FF;
}
.style3 {
	color: #808000;
}
</style>
<center>
<body bgcolor="black">
<img src="p0wnb.png">
<font color="green">

</head>
<?php
include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = new RegexSolution('^p0wnBrowser');
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

$answer = $_SERVER['HTTP_USER_AGENT'];
$valid = $validator->validateSolution($answer);
if ($valid) {
	echo "<h1>Congratulations!</h1>";
} else {
	echo "<h2><br><br>Unfortunately, you cannot access the contents of this site...<br>
	In order to do this, you must buy p0wnBrowser. It only costs 3500 euros.";
}
?>

</html>
