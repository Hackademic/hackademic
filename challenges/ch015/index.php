<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 15</title>
<center>
<body bgcolor="black" style="margin-left:35px">
<img/>
<font color="green">
</head>
<body>

<h1>
<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

$done=0;
if (preg_match('/https?:\/\/example\.com/',$_SERVER['HTTP_REFERER']))
{
	if (preg_match('/^https?:\/\/example\.com/',$_SERVER['HTTP_REFERER']) OR !(preg_match('/challenges\/ch015\/index.php/',$_SERVER['HTTP_REFERER'])) )
	{
	echo 'Access Denied<br/>';
		echo 'It appears that you have spoofed the referred header.The secure browser helps us identify Referer Spoofing.
			<br />Hint: An Insecure Regular Expression is used to validate the referrer address.<br/>';  
	}
	else if (preg_match('/challenges\/ch015\/index.php/',$_SERVER['HTTP_REFERER']))
	{
		$monitor->update(CHALLENGE_SUCCESS);
		$done=1;
		echo 'Congratulations<br />';
	}

}
else
{
	$monitor->update(CHALLENGE_FAILURE);
	echo 'Access Denied<br/>';
	echo '<h3>The request must originate from htpp://example.com</h3><br/>';
}
?>
</h1>
<h3>
<?php
if($done==0)
{
	echo '<a href="javascript:window.location.href=window.location.href">Try Again</a>';
}
?>
</h3>
</center>

</body>
</html>
