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
<body bgcolor="" style=""><h3 style="float:right"> banking_user212@onlinebankmail.com  Server Time: 22:04 hrs</h3>
	<h1 align="center" >Internet Banking Portal</h1>
	<ul style="list-style-type:none">
	<li><a href="index.php">Home</a></li>
	<li><a href='?transfer=1'>Payments/Transfers</a></li>
	<li><a href="?security_tips=1">Security Tips</a></li>
	<li><a href='?feedback=1'>Feedback/Issues</a></li>
	</ul>
<?php
if(isset($_SESSION["credit"]))
{$credit=$_SESSION["credit"];}
else
{$credit=0;}
if($credit>0)
{
	echo '<b>Notification: </b>You have been credit an amount of Rs.'.$credit.' by banking_user907@onlinebankmail.com<br/><br/> ';
}
?>	
<?php if(isset($_GET["transfer"]))
{	
	$csrf=md5("banking_user212@onlinebankmail.com"."22");
	echo 'You can use the following service to transfer funds into beneficiary\'s account. <br/> Be sure to enter the correct details as the transfers are irreversible. You can contact our customer care for more details.';
	echo '<form>
	Beneficiary\'s Email Address: <input type="text" name="to"/><br/>
	Amount to be credited into Beneficiary\'s Account: <input type="text" name="amount"/><br/>
	Remarks: <input type="text" name="remarks" />
	<input type="hidden" name="csrf_token" value="'.$csrf.'" />
	<input type="hidden" name="transfer" value="1" />
	<br/><input name="submit_transfer" type="submit" value="Transfer Amount"/>
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
	echo 'Follow these security tips for safe internet banking:<br/>
	<ol>
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
	echo 'You can always submit any feedback/complaints.
	<form method="post">
	Name: <input type="text" name="f_name" /><br/>
	Email: <input type="text" name="f_email" /><br/>
	Account Number: <input type="text" name="f_account" /><br/>
	Feedback/Complaint:<textarea name="f_text"></textarea><br/>
	<input type="submit" value="submit"/><br/>
	</form>
	
	<br/>Please do not post/discuss any issue at the <a href="forum.php">consumer forum</a>. (Its an unofficial forum, we do not hold any responsiblity for the issues posted there.)';
}
else
{
	
	echo '
	<h4 style="margin-left:20%">Account Information:</h4>
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
	</table>';
}
?>
</body>
</html>
