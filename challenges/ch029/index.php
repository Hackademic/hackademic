<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 29</title>
</head>
<?php
include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;
?>
<div style="font-size:30px;color:#4A75AA">  &nbsp;Internet Banking Portal
<img align="right" src="rt.png"/></div>
<body bgcolor="#F4F8F9" style="margin:0px">
<style>
td a{text-decoration:none;color:white} 
label { display: inline-block; width:250px;text-align: right;}
</style>

<table style="width:100%;background-color:#5A86DD;">
<tr>
<td></td>
<td><a href="index.php">Home</a></td> 
<td><a href='?transfer=1'>Payments/Transfers</a></td>
<td><a href="?security_tips=1">Security Tips</a></td>
<td><a href='?feedback=1'>Feedback/Issues</a></td>
</tr>
</table>
<center>Welcome to <div style="color:#0187B6;display:inline">Personal Banking</div></center>
<div style="margin-left:40px;margin-right:40px;padding:10px;background-color:white;border:1px solid #A9A9A9;">

<center>
	<div style="float:right"> Server Time: 22:04 hrs</div>
<br/>
<?php
if(isset($_SESSION["credit"]))
{$credit=$_SESSION["credit"];}
else
{$credit=0;}
if($credit>0)
{
	echo '<br/><b>Notification: </b>You have been credited an amount of Rs.'.$credit.' by banking_user907@onlinebankmail.com<br/><br/> ';
}
?>	
<?php if(isset($_GET["transfer"]))
{	
	$csrf=md5("banking_user212@onlinebankmail.com"."22");
	echo '<div style="text-align:left">You can use the following service to transfer funds into beneficiary\'s account. <br/> Be sure to enter the correct details as the transfers are irreversible. You can contact our customer care for more details.</div>';
	echo '<form>
	<label>Beneficiary\'s Email Address:</label> <input type="text" name="to"/><br/>
	<label>Amount to be credited :</label> <input type="text" name="amount"/><br/>
	<label>Remarks:</label> <input type="text" name="remarks" />
	<input type="hidden" name="csrf_token" value="'.$csrf.'" />
	<input type="hidden" name="transfer" value="1" />
	<br/><br/><input name="submit_transfer" type="submit" value="Transfer Amount"/>
	</form>';	
	
	if(isset($_GET["submit_transfer"]))
	{

		if($_GET["csrf_token"]==$csrf)
		{
			echo 'Sorry! Not enough funds to transfer or invalid benificiary<br/>';
		}
		else
		{
			$monitor->update(CHALLENGE_FAILURE);
			echo 'Invalid token<br/>
			This could happen because of the following reasons:
			<br/>1. The token might not be the one associated with your account.Some malware/proxies might have changed it.
			<br/>2. The token might have expired.Login in again if your session is more than an hour old.';
		}

			
	}
	
}
else if(isset($_GET["security_tips"]))
{
	echo '<div style="text-align:left">Follow these security tips for safe internet banking:<br/></div>
	<ol style="text-align:left">
	<li> Never reveal your password to anyone</li>
	<li> Change your password frequently</li>
	<li> If you ever lose your secondary device,like mobile phone which is associated with your account,change your password immediately and block that mobile number.</li>
	<li> Do not click on any links in any e-mail message to access the site.</li>
	<li> Always keep your computer free of malware. </li>
	<li> Always check the last log-in date and time in the post login page.</li>
	<li> <b>Beware of phishing attacks.</b></li>
	</ol>'; 
}
else if(isset($_GET["feedback"]))
{
	echo 'You can always submit any feedback/complaints.<br/><br/>
	<form method="post">
	<label>Name: </label> <input type="text" name="f_name" /><br/>
	<label>Email: </label> <input type="text" name="f_email" /><br/>
	<label>Account Number: </label> <input type="text" name="f_account" /><br/>
	<label>Feedback: </label><textarea  name="f_text" ></textarea><br/>
	<input type="submit" value="submit"/><br/>
	</form>
	
	<br/>Please do not post/discuss any issue at the <a href="forum.php">consumer forum</a>. (Its an unofficial forum, we do not hold any responsiblity for the issues posted there.)';
}
else
{
	
	echo '
	<h4 >Account Information:</h4>
	<table width="60%" align="center">
	<tr>
	<td>Name: </td><td>Banker212</td>
	</tr>
	<td>Account Number: </td><td>OB00002174546985</td>
	<tr>
	<td>Email: </td><td>banking_user212@onlinebankmail.com</td>
	</tr>
	<tr>
	<td>Available balance: </td><td>'.$credit.'</td>
	</tr>
	</table><br/>';
}
?>
</center>
</div>
</body>
</html>
