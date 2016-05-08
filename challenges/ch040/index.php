<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 20</title>
</head>

<body bgcolor="" style="margin-left:35px">
<center>
<img src="seo1.png">

<hr >

<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

?>

<blockquote> 
"We are the best SEO and web-security providers on this planet.We provide you greater exposure and improve your client database. For instance, you can check this website's search engine visibility. We are always listed on the top. We have successfully regulated the contents to be crawled by the search engines.There will not be even a single unnecessary or a dead link. Have confidence in us,we will improve your website's security and visibility to the maximum level."
</blockquote>
-Admin
<br>admin@emailprovider.com

<br/>
<br>
<?php
if (isset($_POST['email']) or isset($_POST['password']))
{
	if($_POST['email']=='admin@emailprovider.com' and $_POST['password']=='secures')
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
	}
}
?> 
<form method='post'>
Email: <input type='text' name='email' />
<br/>
Password: <input type='password' name='password' />
<br/>
<input type='Submit' value="Login" />
</form>

</center>

</body>
</html>
