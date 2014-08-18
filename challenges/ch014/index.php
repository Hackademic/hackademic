<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 14</title>
<center>
<img src="mobi_store.png">
</center>
</head>
<body bgcolor="white" style="margin-left:35px">
<font color="green">

<h2>
<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

include "start_db.php";

$connect=mysqli_connect(DB_HOST,$database_name,'hackademic_password',$database_name);

echo '<center>';
echo '<h1 style="display:inline">Enter A Brand:</h1>
<form method="post">
<input name="brand"/>
<input type="Submit" value="Search" style="display:inline;"/>
</form>
<div style="color:black" >example: Nokia,Apple,Samsung</div>
<br/><br>';

if(isset($_POST['user']))
{
	if($_POST['user']=="qgtdfsdszpwwr2@exzzecs.com" and $_POST['password']=="Hello")
	{
		echo 'Congratulations<br />';
		$monitor->update(CHALLENGE_SUCCESS, $_GET);
	}
	else
	{	
		echo 'Invalid Login<br />';
		$monitor->update(CHALLENGE_FAILURE, $_GET);
	}
}

if(isset($_POST['brand']))
{					
	$query="SELECT * FROM MobiStore_Mobiles WHERE Company='".$_POST['brand']."';";
}
else
{
	$query="SELECT * FROM MobiStore_Mobiles";

}
	$result= mysqli_query($connect,$query);
	
	echo '<table border="1" width="70%" style="color:green;font-size:30;text-align:center">';
	while( $row=mysqli_fetch_array($result))
	{
		echo "<tr>";
		echo "<td>".$row[1]."</td>";
		echo "<td><img src='logos/".$row[3].".jpg'/></td>";
		echo "</tr>";
	}
	echo "</table>";
	echo mysqli_error($connect);

if(isset($_POST['new_user']))
{
	if(!filter_var($_POST['new_user'], FILTER_VALIDATE_EMAIL))
	{
		echo 'Error inserting into table "MobiStore_members".Invalid Email<br/>';
	}
	else
	{
		echo "Thanks for your interest.We'll notify on your membership<br/>";
	}
}

echo '</center></font>';

echo '<br/><div style="float:left">Login<br><br />
<form method="post">
Email: <input type="text" name="user"/><br/>
Password: <input type="password" name="password"/><br />
<input style="margin-left:300px" type="submit" value="Submit" /></form><br></div>';

echo '<br />New User<br>
<form method="post">
Email:<input type="text" name="new_user" value="example@example.com"/>
<input type="submit" value="Get Membership" style="display:inline;"/>
</form>
';

include "stop_db.php";
?>




</body>
</html>
