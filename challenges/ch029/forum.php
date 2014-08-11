<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Consumer Forum</title>
</head>
<?php
include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;
?>
<hr/>
<?php
	
if(isset($_POST["submit"]))
{
	echo 'Your issue has been posted.<br/>';
	echo 'Posted by: <b>'.$_POST["email"].'</b><br/>';
	echo htmlentities($_POST["text"]);
	echo '<img src="'.addslashes($_POST["image_url"]).'"/> <br/><br/>';
	$split = explode('?', $_POST["image_url"]);
	$new_url = $split[0];
	parse_str($split[1], $output);
	if(strpos($new_url,'ch029/index.php') !== false and isset($output["submit_transfer"]))
	{
		$csrf2=md5("banking_user907@onlinebankmail.com"."22");

		if( $output["csrf_token"]==$csrf2 )
		{
			if($output["to"]=="banking_user212@onlinebankmail.com")
			{
				if(isset($_SESSION["credit"]))
				{
					$_SESSION["credit"]=$_SESSION["credit"]+$output["amount"];
				}
				else
				{
					$_SESSION["credit"]=$output["amount"];
				}
			}
			if($_SESSION["credit"]>=1200)
			{
				echo 'Congratulations!!<br/>';
				$monitor->update(CHALLENGE_SUCCESS);
			} 
		}
		else
		{
			$monitor->update(CHALLENGE_FAILURE);
		}
	}
	echo '<!-- Check your bank account to see whether the csrf has succeeded or not. -->';
}
echo 'Posted by: <b> banking_user907@onlinebankmail.com </b><br/>';
	echo 'Hi, I am new to online banking. Can some please help me with the process?. Please reply me soon, I will be constantly looking at the forum for the help.<br/>';
?>
<h4>Post in this forum:</h4>
<b>Guidelines: </b> Do not try to tamper with the forum.Using html/javascript in the post is not allowed.Optionally, you can add an image describing the problem (for example, a screenshot of the issue). Using script anywhere, in anyform is not allowed.
<form method="post">
Email: <input type="text" name="email"/><br/>
Text: <textarea name="text" ></textarea><br/>
Image Url: <input type="text" name="image_url"/><br/>
<input type="submit" name="submit" value="Submit"/>
</form>

