<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 15</title>

<body  bgcolor='black' style="margin-left:35px">
<center>
<img src="announcement.png"/>

<font color="white">
</head>
<body>
<?php
include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;
?>
<br /><p style="font-size:25">
<?php
if(isset($_GET['location']))
{	
	if($_GET['location']=='90.0000° S, 0.0000° W')
	{	
		$monitor->update(CHALLENGE_SUCCESS);
		echo '<b>Congratulations !!<br/>I wonder where these coordinates lead to..  </b><br/>'; 
	}
	else
	{	
		$monitor->update(CHALLENGE_FAILURE);
		echo '<b>Wrong location.</b><br/>';
	}
	echo '<br/>';
}
?>
The commander of Aliens has again ordered for the attack. They have reached earth and established their station somewhere. They have also been operating a webserver from that station. One of the services running on their server is <a href='alien.php'>here</a>.We need their location to attack them. We can know their location if the command 'location' is run on their server (don't worry...thats an alien command). If you find the location, please enter it here.<br/><br/>

<form method="get">
Location: <input type='text' name='location'/>
<input type='submit' value="Submit" />
</form></p>
</center>

</body>
</html>
