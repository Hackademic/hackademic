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
<body>
Public key can be downloaded <a href='public.txt'>here</a>. The cipher text is <a href='cipher.txt'>here</a>.


<form method="post">
<input type="text" name="plaintext" />
<input type="submit" value="Submit Plaintext"/>
</form>
</body>
</html>
