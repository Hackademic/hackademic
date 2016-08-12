<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 22</title>
</head>

<body bgcolor="black" style="margin-left:35px">
<center>
<font color="green">
<h1 style="background:#FF9">The Great Hackers Challenge</h1>

<div style="background:#FC0">
<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;
$password="7809243hyu432";


?>
Welcome to "The Great Hackers Challenge".
<br/>
</div >
<br/>
<div style="background:#FC0">Try to break the authentication of this website.We have used standard procedures for authentication and so,there is no chance of any vulnerbility.You can even view the sample code used for authentication <a href='auth.php.txt'>here</a>. 
<br/>
<b>Hint:</b> Try to get the value of variable $password.You can also try to alter the value of $password variable to match your password.
</div>
<br/><br/><br/>
<div style="background:#FC0">
<br/>
<h3>LOGIN:</h3>
<hr style="height:2;border: none;background-color:black"/>
<br/>
<?php
if(isset($_POST["password"]))
{
	if(!strcmp($password,$_POST["password"]))
	{
		$monitor->update(CHALLENGE_SUCCESS);
		echo '<h2>Congratulations!!</h2>';
	}
	else
	{
		$monitor->update(CHALLENGE_FAILURE);
		echo 'Wrong Password.';
	}
}
?>
<form method="post">
<input type="password" name="password"/>
<input type="Submit" value="Submit Password"/>
</form>
<br/><br/><br/>
</div>
</font>
</center>

</body>
</html>
