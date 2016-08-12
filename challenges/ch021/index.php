<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 21</title>
</head>

<body bgcolor="" style="margin-left:35px">
<center>
<img src="backup/seo1.png">

<hr >

<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

?>

<h3>Disclaimer:</h3><blockquote> 
"We have faced a cyber attack on our website recently.We are afraid the passwords of all the users have been compromised.We have migrated our website to a new server and we request all the users to register again.We have improved our security and the passwords are not stored in plaint-text anymore.We have also improved the security of login process.<br/>We assure you complete security.Have a great day!!"
</blockquote> 
-Admin
<br/>admin@emailprovider.com

<br/>
<br>

<h4>Login</h4>
<?php
if (isset($_POST['email']) or isset($_POST['password']))
{	echo '<b>';
	if($_POST['hidden_field']!='set')
	{
		$monitor->update(CHALLENGE_FAILURE);
		echo 'Invalid Login<br/><br>';
		
	}
	else if($_POST['email']=='admin@emailprovider.com' and $_POST['password']=='wah')
	{
		$monitor->update(CHALLENGE_SUCCESS);
		echo 'Welcome Admin<h2><br/>Congratulations!!</h2><br/>';
	}
	else
	{
		$monitor->update(CHALLENGE_FAILURE);
		if(strpos($_POST['password'],'@')!==False)
		{
		echo 'Invalid Login<br/><br>';
		}
		else
		{
		echo 'Invalid Email<br/>';
		}
	}echo '</b>';
}

?> 
<form method='post'>
Email: <input type='text' name='email' />
<br/>
Password: <input type='password' name='password' />
<br/>
<input type="hidden" name='hidden_field' value='set' />
<input type='Submit' value="Login" />
</form>


<h4>Register</h4>
<?php
if (isset($_POST['reg_email']) or isset($_POST['reg_password']))
{	
	if(strlen($_POST['reg_password'])>=4 or !(ctype_lower($_POST['reg_password'])) )
	{
		echo '<b>Password can have a maximum of 3 characters and should only contain lowercase alphabets.</b>'; 
	}
	else
	{
		echo '<b>Password meets our specifications.You are registered.</b>'; 
	}
}
?>
<form method='post'>
Email: <input type='text' name='reg_email' />
<br/>
Password: <input type='password' name='reg_password' />
<br/>
<input type='Submit' value="Register" />
</form>

</center>

</body>
</html>
