<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 25</title>
</head>
<body style="background-image:url('back.jpg');margin:0 0;">
<center>


<?php
include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

if(isset($_POST["email_login"]))
{
	if($_POST["email_login"]=="user234@email.com" and $_POST["password_login"]=="Usr@#\$lc")
	{
		setcookie("cookie-ch025","pOEw3VmaZYeoz0ooyMqd5PxTrcXIB9O9y");
		header("Location:index.php");
	}
}
if(isset($_GET["logout"]))
{
	setcookie("cookie-ch025","",1);
	header("Location:index.php");
}
if(!isset($_COOKIE["cookie-ch025"]))
{
if(isset($_GET["forgotpassword"]))
{
	if(!isset($_POST["forgot_email"]))
	{
	echo '
	<h3>Answer the security question to unlock the account</h3>
	<form action="?forgotpassword=1" method="post">
	Email:&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="forgot_email"><br/>
	Question:  <input type="text" name="forgot_ques"><br/>
	Answer:&nbsp;&nbsp; <input type="" name="forgot_ans"><br/>
	<input type="submit" value="Submit"/>
	</form>
	';
	}
	else
	{
		if($_POST["forgot_email"]=="user234@email.com" and $_POST["forgot_ques"]=="What is the service tag of your first laptop" and $_POST["forgot_ans"]=="Jc4pwq1")
		{
			echo 'Recovery Successful.You will be logged into the account now';
			 echo '<div id="myDiv"></div><script>
			 var xmlhttp;
			if (window.XMLHttpRequest)
 			 {
 				 xmlhttp=new XMLHttpRequest();
 			 }
			else
 			 {
 				 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }

			xmlhttp.onreadystatechange=function()
  			{
  				if (xmlhttp.readyState==4 && xmlhttp.status==200)
  				  {	
  				  	document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
					setTimeout(function(){window.location="index.php";}, 2000);
					
 				   }
			  }
			xmlhttp.open("GET","sc.php?recovery=user234@email.com&token=861b62467e9a0b491f269c3c3f0d80784ab5c885",true);
			xmlhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
			xmlhttp.send();
			 </script>';
		}
		else
		{
		header("Location:index.php?forgotpassword=1");
		}
	}
	
}
else
{
?>

<div style="width:40%;margin: 0 auto;margin-top:10%;background-image:url('login.jpg');background-repeat:no-repeat;background-size: 100% 100%;" >
<img src="logo2.png" style="width:40%;margin: 0 auto;"/>
<br/><br/>
<form style="color:white;margin: 0 auto;" method="post">
Email: <br/><input type="text" name="email_login"/><br/>
Password:<br/> <input type="password" name="password_login"/><br/><br/>
<input type="submit" value="Login"/>
</form>

<br/><br/>
</div><br/><a style="font-size:12px" href='?forgotpassword=1'>Forgot password?</a>
<?php
}
}
else if ($_COOKIE["cookie-ch025"]=="pOEw3VmaZYeoz0ooyMqd5PxTrcXIB9O9y")
{	
	echo '<div style="background-color:black;color:white;text-align:center"><h2 style="display:inline;"><img src="logo3.png"/> </h2></div>';?><div style="float:right">user234@email.com <a href="?logout=1">Logout</a></div>

<div style="height:100%;background-size:100% 100%;background-repeat:no-repeat;background-image:url('login.jpg');float:left;width:20%">
<br/>
<br/>
<style>
a:link {
    color: white;
}
a:visited {
    color: blue;
}
</style>
<table style="font-size:20px;color:white">
<tr><th>Folders<br/><br/></th></tr>
<tr><td><a href="index.php">Inbox</a></td></tr>
<tr><td><a href="?sent=1">Sent<a></td></tr>
<tr><td><a href="?drafts=1">Drafts</a></td></tr>
<tr><td><a href="?settings=1">Settings</a></td></tr>
</table>

</div>

<h3 style="display:inline;">You are currently viewing the Mobile Version of this mail client.</h3> 	<br/><br/>
<?php
if(isset($_GET["sent"]))
{
	echo '<h4>Sent Items</h4>
	<div style="padding:10px;border-radius: 5px;background:white;width:60%;margin-left:20%;text-align:left">
	<b>From:</b> "User234" &lt; user234@email.com &gt; <br/>
	<b> To:</b> "User962" &lt; user962@email.com &gt; <br/>	 
	<b>Subject:</b> "Access to the Central Server"  <br/>
	<hr/>
Hello User963,<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I am hereby sending the credentials of the Central Server.
     The details(pem file..) are very confidential and should never be shared with anyone else.
<br/><br/>
Regards,<br/>
User234<hr/>
<b>Attachments:</b> "key.pem" <a href="">Download</a><br/>
	</div>
	';
}
else if(isset($_GET["drafts"]))
{
	echo '<h4>Drafts</h4>The folder is empty
	';
}
else if(isset($_GET["settings"]))
{
	echo '<h4>Account Settings</h4>
	<div style="border-radius: 5px;background:white;width:60%;margin-left:20%">
	<table width="60%" style="border-spacing:1em;">
	<tr><td>Username:</td> <td>User234</td></tr>
	<tr><td>Email:</td> <td>user234@email.com</td></tr>
	<tr><td>Password:</td> <td>******* &nbsp;&nbsp;&nbsp;<a href="">Edit Password</a></td></tr>
	<tr><td>Security Question :</td> <td>What is the service tag of your first laptop</td></tr>
	<tr><td>Answer:</td> <td><input type="password" value="Jc4pwq1"/></td></tr>
	</table>
	</div>
	';
	
}
else
{
	echo '<h4>Inbox</h4>
	<div style="border-radius: 5px;background:white;width:60%;margin-left:20%">Hi User234, <br/>No messages yet!</div>
	';
}

}
else if ($_COOKIE["cookie-ch025"]=="Mqd5PxTrcXIB9O9ypOEw3VmaZYeoz0ooy")
{
if(isset($_GET["delete"]))
{
	if($_GET["delete"]=="17609")
	{
		$monitor->update(CHALLENGE_SUCCESS);
		echo '<h2>Congratulations!!<br/></h2>';
	}
}
	echo '<div style="background-color:black;color:white;text-align:center"><h2 style="display:inline;"><img src="logo3.png"/> </h2></div>';?><div style="float:right">user962@email.com <a href="?logout=1">Logout</a></div>

<div style="height:100%;background-size:100% 100%;background-repeat:no-repeat;background-image:url('login.jpg');float:left;width:20%">
<br/>
<br/>
<style>
a:link {
    color: white;
}
a:visited {
    color: blue;
}
</style>
<table style="font-size:20px;color:white">
<tr><th>Folders<br/><br/></th></tr>
<tr><td><a href="index.php">Inbox</a></td></tr>
<tr><td><a href="?sent=1">Sent<a></td></tr>
<tr><td><a href="?drafts=1">Drafts</a></td></tr>
<tr><td><a href="?settings=1">Settings</a></td></tr>
</table>

</div>

<h3 style="display:inline;">You are currently viewing the Mobile Version of this mail client.</h3> 	<br/><br/>
<?php
if(isset($_GET["sent"]))
{
	echo '<h4>Sent Items</h4>
	<div style="border-radius: 5px;background:white;width:60%;margin-left:20%">No Messages Sent</div>
	';
}
else if(isset($_GET["drafts"]))
{
	echo '<h4>Drafts</h4>The folder is empty
	';
}
else if(isset($_GET["settings"]))
{
	echo '<h4>Account Settings</h4>
	<div style="border-radius: 5px;background:white;width:60%;margin-left:20%">
	<table width="60%" style="border-spacing:1em;">
	<tr><td>Username:</td> <td>User962</td></tr>
	<tr><td>Email:</td> <td>user962@email.com</td></tr>
	<tr><td>Password:</td> <td>******* &nbsp;&nbsp;&nbsp;<a href="">Edit Password</a></td></tr>
	<tr><td>Security Question :</td> <td>None</td></tr>
	<tr><td>Answer:</td> <td>None</td></tr>
	</table>
	</div>
	';
	
}
else
{
	echo '<h4>Inbox</h4>
	<div style="padding:10px;border-radius: 5px;background:white;width:60%;margin-left:20%;text-align:left">
	<b>From:</b> "User234" &lt; user234@email.com &gt; <a style="float:right" href="index.php?delete=17609">Delete</a><br/>
	<b> To:</b> "User962" &lt; user962@email.com &gt; <br/>	 
	<b>Subject:</b> "Access to the Central Server"  <br/>
	<hr/>
Hello User963,<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I am hereby sending the credentials of the Central Server.
     The details(pem file..) are very confidential and should never be shared with anyone else.
<br/><br/>
Regards,<br/>
User234<hr/>
<b>Attachments:</b> "key.pem" <a href="">Download</a><br/>
	</div>
	';
}

}
?>
</center>

</body>
</html>
