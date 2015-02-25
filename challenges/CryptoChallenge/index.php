<?php

/**
 *    ----------------------------------------------------------------
 *    OWASP Hackademic Challenges Project
 *    ----------------------------------------------------------------
 *    Author:
 *    Stavros Miras
 *    ----------------------------------------------------------------
 */

require_once($_SESSION['hackademic_path']."pages/challenge_monitor.php");

if (isset($_POST['password']) && $_POST['password']=='56c80<j9')
	echo "<h1><br><center>Congratulations!</br></cetner></h1>";
	$monitor->update(CHALLENGE_SUCCESS);
else
	$monitor->update(CHALLENGE_FAILURE);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
<title>Challenge - Cryptographic</title>
<style>
p{
color:white;
}
</style>
</head>

<body bgcolor="black">

<br>
<br>
<center>
<p>The network administrator has encrypted his password. The encryption system is publically available and can be accessed with this form:</p>

<br>

<p>Please enter a string to have it encrypted.</p>
<form action="encryption.php" method="post">
<input name="text" type="text"><br>
<input value="encrypt" type="submit"></form>

<br>
<p>You have recovered his encrypted password. It is:
<br>
<b>57e;4Ap@</b>
</p>

<br>
<p>Decrypt the password and enter it below to advance to the next level.</p>
<br>

<p><b>Password:</b></p>
<form action="index.php" method="post">
<input name="password" type="password">
<br><br>
<input value="submit" type="submit"></form>

</center>

</body>

</html>
