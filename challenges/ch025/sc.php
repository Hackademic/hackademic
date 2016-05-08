<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) or ! ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'))
{
	echo 'Not a valid ajax request';
	$monitor->update(CHALLENGE_FAILURE, $_GET);
	exit();
}
if($_GET["recovery"]=="user234@email.com" and $_GET["token"]=="861b62467e9a0b491f269c3c3f0d80784ab5c885")
{
setcookie("cookie-ch025","pOEw3VmaZYeoz0ooyMqd5PxTrcXIB9O9y");
}
else if($_GET["recovery"]=="user962@email.com" and $_GET["token"]=="403c50a8cf865d9610b0711e2c7e7e54c6656423")
{
setcookie("cookie-ch025","Mqd5PxTrcXIB9O9ypOEw3VmaZYeoz0ooy");
}
else
{
			$monitor->update(CHALLENGE_FAILURE, $_GET);
	echo 'Token/hash doesn\'t match';
}
?>
