<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 19</title>
</head>

<body bgcolor="#00 " style="margin-left:35px">
<center>
<img src="xor1.png">

<hr style="">
<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

/*
Xor Encryption with repeated key+base64 encoding
*/
?>

<p style="font-size:25;background:#FFFF99;" >

This time you are assigned a task to break the most secure XOR cipher. <a href='encrypted2.txt'/>Here</a> is a message encrypted with xor cipher.<br/>Also,some extra measures have been taken to further improve the security of cipher text.You are also given a <a href='plain1.txt'>plaintext</a> and corresponding <a href='encrypted1.txt'>ciphertext</a> encrypted with same key,to assist you .

<br/>
<br></p>
<?php
if (isset($_POST['message']))
{
	if($_POST['message']=='Never use the same key twice for xor encryption.')
	{
		$monitor->update(CHALLENGE_SUCCESS);
		echo '<h2>Congratulations!!</h2><br/>';
	}
	else
	{
		$monitor->update(CHALLENGE_FAILURE);
		echo 'Incorrect Message<br/><br>';
	}
}
?> 
<form method='post'>
<input type='text' name='message' />
<input type='Submit' value="Verify Plaintext" />
</form>
</center>

</body>
</html>
