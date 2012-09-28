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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 003</title>
<center>
<body bgcolor="black">
<img src="xssme1.png">
<font color="green">
</head>
<body>
<h2>
<hr>
<?php
session_start();
require_once($_SESSION['hackademic_path']."pages/challenge_monitor.php");
	$try_xss = $_POST['try_xss'];
	if  ( ($try_xss == '<script>alert("XSS!");</script>') OR
		  ($try_xss == "<script>alert('XSS!');</script>") ) {
    		echo 'Thank you'.' '.($_POST['try_xss']).'!';
			echo "<H1>Congratulations!</H1>";
			$monitor->update(CHALLENGE_SUCCESS);
	
    } 
	else {
		$monitor->update(CHALLENGE_FAILURE);
?>
	Try to XSS me using the straight forward way... <br />
	<form method="POST">
	<input type="text" name="try_xss" />
	<input type="submit" value="XSS Me!" />
	</form>
<?php 
	}
?>
<hr>
</h2>
</body>
</html>

