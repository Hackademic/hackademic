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
<center>
<img src="forum.png"/></center>
<hr/>
<h3 align="center">Recent Posts</h3>
<?php
	
if(isset($_POST["submit"]))
{
	echo '<center>Your issue has been posted.<br/></center>';
	echo '
<div style="margin:0px 40px;border:1px solid black;padding:10px">
Posted by: <b> '.$_POST["email"].' </b><br/>Time: Just Now<br/><br/>';
	echo htmlentities($_POST["text"]);
	echo '<img src="'.addslashes($_POST["image_url"]).'"/> <br/></div><br/>';
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

echo '
<div style="margin:0px 40px;border:1px solid black;padding:10px">
Posted by: <b> banking_user907@onlinebankmail.com </b><br/>Time: Just Now<br/><br/>';
	echo 'Hi, I am new to online banking. Can some please help me with the process?. Please reply me soon, I will be looking at the forum for the help.<br/>
</div><br/>	';
echo '
<div style="margin:0px 40px;border:1px solid black;padding:10px">
Posted by: <b> banking_user767@onlinebankmail.com </b><br/>Time: 3 days ago<br/><br/>';
	echo 'Hello all,<br/> How to activate mobile sms banking service for my account? Is there be any standard procedure to apply for it? Thanks.<br/>
</div><br/>	';
?>
<h4 align="center">Post in this forum:</h4>
<style>
label {  vertical-align: middle;display: inline-block; width:100px;text-align: right;}
input {width:23%;margin:2px 0px;}
textarea {width:23%; vertical-align: middle;}
</style>
<center><form method="post">
<label>Email: </label> <input type="text" name="email"/><br/>
<label>Text: </label> <textarea rows="5" name="text" ></textarea><br/>
<label>Image Url: </label> <input type="text" name="image_url"/><br/><br/>
<input style="width:10%"type="submit" name="submit" value="Submit"/>
</form>
</center>
