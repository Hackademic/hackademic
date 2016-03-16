<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Treasure</title>
</head>
<body>

<?php

include_once dirname(__FILE__).'/../../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

echo 'Congratulations!!<br/> You have found the treasure<br/>';
	$monitor->update(CHALLENGE_SUCCESS, $_GET);
?>
