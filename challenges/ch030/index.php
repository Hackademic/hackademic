<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 30</title>
</head>
<?php
include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;


echo '<body style="background-image:url(\'logo.png\');background-size:22%;" ><br/><center>
<div style="margin:10%;background-color:white;margin-top:15%;padding:10px;vertical-align:middle;border:1px solid  black">
<h2>';
if(isset($_POST["plaintext"]))
{
	if($_POST["plaintext"]=="IS RSA BROKEN?")
	{
		echo 'Congratulations!!<br/>';
		$monitor->update(CHALLENGE_SUCCESS);
	}
	else
	{
		$monitor->update(CHALLENGE_FAILURE);
	}
}
?>

Public key : <a href='public.txt'>public.txt</a><br/> Cipher text : <a href='cipher.txt'>cipher.txt</a>

<br/>
<form method="post">
<input type="text" name="plaintext" />
<input type="submit" value="Submit Plaintext"/>
</form>
</h2>
</div>
<center>
</body>
</html>
