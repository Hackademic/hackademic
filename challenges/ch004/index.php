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
<title>Challenge 004</title>
<center>
<body bgcolor="black">
<img src="xssme2.png">
<font color="green">
</head>
<body>
<h2>
<hr>
<?php
	session_start();
        require_once($_SESSION['hackademic_path']."pages/challenge_monitor.php");
	// <script>alert(String.fromCharCode(88,88,83,33))</script>
	$try_xss = $_POST['try_xss'];
	//Remove all white space characters.
	$try_xss= preg_replace('/\s+/', '', $try_xss);
	//Semicolon might or might not be present at the end of statement.Match both the cases.
	if(preg_match('/<script>alert\(String.fromCharCode\(88,83,83,33\)\);?<\/script>/',$try_xss)) 
	{
    			echo 'Thank you '.$try_xss.'';
			echo "<H1>Congratulations!</H1>";
			$monitor->update(CHALLENGE_SUCCESS);
        } 
	
	else {
		$monitor->update(CHALLENGE_FAILURE);
?>
	Try to XSS me...Again! <br />
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

