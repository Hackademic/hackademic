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
		include_once dirname(__FILE__).'/../../init.php';
        session_start();
        require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
        $monitor->update(CHALLENGE_INIT,$_GET['user'],$_GET['id'],$_GET['token']);
        // <script>alert(String.fromCharCode(88,88,83,33))</script>
	if(isset($_POST['try_xss'])){
	$try_xss = $_POST['try_xss'];
	if($try_xss == '<script>alert(String.fromCharCode(88,83,83,33))</script>') {
    		echo 'Thank you '.$try_xss.'';
			echo "<H1>Congratulations!</H1>";
			$monitor->update(CHALLENGE_SUCCESS,$_GET['user'],$_GET['id'],$_GET['token']);

    }
	else {
		$monitor->update(CHALLENGE_FAILURE,$_GET['user'],$_GET['id'],$_GET['token']);
?>
	Try to XSS me...Again! <br />
	<form method="POST">
	<input type="text" name="try_xss" />
	<input type="submit" value="XSS Me!" />
	</form>
<?php
	}
	}else{
?>
	Try to XSS me...Again! <br />
	<form method="POST">
	<input type="text" name="try_xss" />
	<input type="submit" value="XSS Me!" />
	</form>
<?php }

?>
<hr>
</h2>
</body>
</html>

