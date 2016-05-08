<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 24</title>
</head>
<body bgcolor="#F9A148" style="margin-left:35px">
<center>
<img  src='logo2.png' />
<div style="float:right;text-decoration:underline;color:blue">user012</div>
<font color="">
<br/>
<h3>
<table width="100%" style="text-align:center">
<tr>
<td><a href='index.php'>Top Sellers</a></td>
<td><a href='?account=1'>My Account</a></td>
<td><a href='?email=1'>Notifications</a></td>
</tr>
</table>
</h3>

<?php
include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

$is_admin=0;

if(!isset($_COOKIE["session-cookie"]))
{
	setcookie("session-cookie","pOEw3VmaZYeoz0ooHgs8QfUVWBV8NAHzpIbLjH");
	setcookie("session-user","user012");
}
else if($_COOKIE["session-user"]!="user012")
{
	if($_COOKIE["session-user"]=="admin" and $_COOKIE["session-cookie"]=="QIfGwkWYm6WsZH5aiyMqd5PxTrcXIB9O9y3IW2y")
	{
		$is_admin=1;
	}
	else
	{
		$monitor->update(CHALLENGE_FAILURE);	
		echo '<script>alert("Invalid Authentication")</script>';
		setcookie("session-cookie","pOEw3VmaZYeoz0ooHgs8QfUVWBV8NAHzpIbLjH");
		setcookie("session-user","user012");
	}
}

if(isset($_GET["accept_28292"]))
{
	if($is_admin!=1)
	{
		echo '<b>You don\'t have necessary permissions.<br/></b>';
	}
	else if($_GET["accept_28292"]=="ORD18765")
	{
		$monitor->update(CHALLENGE_SUCCESS);
		echo '<b>Congratulations<br/></b>';
	}
}
else if(isset($_GET["content_id"]))
{
	$arr=["user012","admin"];
	$to=$arr[$is_admin];
	if($_GET["to"]==$to)
	{
		header("Location:logs.pcap");
	}
	else
	{
		echo '<script>alert("You don\'t have the permission to view this");window.location="index.php";</script><br/>';
		//header("Location:index.php");
	}
}


if(isset($_GET['account']))
{
	if($is_admin==1)
	{
		echo 'Welcome Admin';
	}
	else
	{
	echo '
		Welcome user012
		<h2>Your Orders:</h2>
		<table border="1" width="50%" >
		<tr> 
		<th>OrderId</th> <th>Product</th> <th>Amount</th> <th>Status</th>
		 </tr>
		 <tr>
		 <td>ORD18765</td> <td>Mobile Qc4879</td> <td>562 USD</td> <td>1.Delivered<br/>2.Return Requested<br/>3.Admin has rejected your return request.</td> 
		 </tr>
		</table>
	';
	}
}
else if(isset($_GET['email']))
{
	if($is_admin==1)
	{
	echo '
		Welcome admin
		<h3>Your Notifications:</h3>
		<ul style="display:table;">
		<li>You have rejected the refund of orderId ORD18765.<a href="index.php?accept_28292=ORD18765">Accept</a> </li>
		<li>Return requested for orderId ORD18765</li>
		</ul>
		<br/>';
	
	}
	else
	{
	echo '
		Welcome user012
		<h3>Your Notifications:</h3>
		<ul style="display:table;">
		<li>Product with OrderId ORD18765 delivered.</li>
		<li>Product with OrderId ORD18765 shipped.</li>
		<li>Thankyou for placing the order.You will get notified when the product is shipped.</li>
		</ul>
		<br/>';
	}	
		echo'
		<h3>Public Notifications:</h3>
		<ul style="display:table;">
		<li>Flat 20% off on Fashion sale.</li>
		<li>Weekend Sale!! Buy for 600 and get 100 off.</li>
		<li>Developer Notice:Logs of the website.<a href="index.php?from=developer&to=admin&content_id=27149">View Logs</a></li>
		<li>Celebrating the 1 million sale.10% extra discount on all products.</li>
		</ul>
	';
}

else 
{
	for($i=2;$i<6;$i++)
	{
		echo '<img width=35%" src="products/'.$i.'.jpg"/>';
	}
}
?>

</font>
</center>

</body>
</html>
