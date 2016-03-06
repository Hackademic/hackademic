<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 23</title>
</head>

<body bgcolor="" style="">
<center>
<img src="logo.png" width="100%"/>
<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

//give absolute path of password file in hidden/.htaccess file
$data=realpath("hidden_key/.htpasswd");
$data='AuthUserFile '.$data;
$f ="hidden/.htaccess";
$arr = file($f);

if($arr[0]!= $data)
{
	$arr[0] = $data."\n";
	file_put_contents($f, $arr);
}


?>
<h2 style="background:yellow;color:green">Welcome to the first ever Web Treasure Hunt</h2>
<?php
if(isset($_GET['viewfile']))
{
	$file=realpath($_GET['viewfile']);
	if($file==realpath("rules.txt") or $file==realpath("hints.txt") or $file==realpath("winner.txt") )
	{
		include $file;
	}
	else if( $file==realpath(".htaccess") or $file==realpath("hidden/.htaccess") or $file==realpath("hidden_key/.htpasswd") or $file==realpath("hint_1492.txt") )
	{
		include $file;
		echo '<br><b>Status: </b>You have unlocked a new hint.';
	}
	else
	{
		echo 'Error,the file can\'t be included.<br/>';
		echo '<b>Hint: </b>Try to view hidden files';
	}
}
?>
<table width="75%">
<tr>
<td><a href='?viewfile=rules.txt' ><img style="float:left"  src='rules2.jpeg' /></a></td>
<td><a href='?viewfile=hints.txt'><img src='hints.jpeg'  style="float:right;margin-top:10px"  /></a></td>
</tr>
</table>
<br/>
<a href='?viewfile=winner.txt'><img src='winner.jpeg' /></a>
</center>

</body>
</html>
