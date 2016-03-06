<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 28</title>
</head>
<?php
include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;
?>
<body bgcolor="#FFFFCC" style="">
<h1 align="center" id="heading1" style="color:brown">Man In the Middle - Diffie Hellman</h1>


<?php 
if(isset($_GET["detail"]))
{
?>
<center>You can perform MIM  <a href="index.php">here</a></center><br/>
<center>The following protocol is used for the Diffie Hellman Key Exchange:
<br/>
Consider 2 parties A and B:</center>
<table width="70%" align="center"  border="1" style="border-collapse:collapse;text-align:left;" >
<tr> <th>User A </th> <th> User B </th> </tr>
<tr><td> 1.Select prime q and r, prmitive root of q (0 &lt; q &lt; 30) 
<br/> 2.Select private XA such that, XA &lt; q  
<br/> 3.Calculate public YA such that YA= r<sup>XA</sup> modq 
<br/> 4.Send {q,r,YA} <br/> <img src="1rt.png"/> </td> <td> </td></tr>
<tr><td> </td> <td>1.Send {YB} calculated using the recieved q,r.<br/> <img src="2lt.png"/>  </td></tr>
<tr><td> 5.Calculate key K= YB<sup>XA</sup> modq </td> <td>2.Calculate key K= YA<sup>XB</sup> modq </td></tr>
</table>
<?php
}
else
{
?>
<center>You can view the details and constraints of the Key Exchange <a href="?detail=1">here</a></center><br/>
<style>
td{padding:15px}
</style>
<table width="85%" align="center" style="text-align:center;">
<?php
if(! isset($_GET["intercept"]))
{

?>
<tr>
<th>Alice</th>
<th></th>
<th> </th>
<th></th>
<th>Bob</th>
</tr>
<tr>
<td><img src="alice.png"/></td>
<td colspan="3">Starting Difffie Hellman Key Exchange Between Alice and Bob...<br/> <a href="?intercept=1">Intercept the Channel</a></td>
<td><img src="alice.png"/></td>
</tr>
<?php }
else
{
$xa=9;
?>
<center>You have successfully intercepted the channel.The messages sent by Alice will be recieved by you instead of Bob.</center> 
<tr>
<td><img src="alice.png"/></td>
<td><img src="1rt.png"/><br/> {q:11,r:2,YA:6}</td>
<td><img style="width:128" src="eve.png"/></td>
<td><img src="2rt.png"/><br/>
<?php
$var0=0;
if(isset($_GET["to_bob"]) and $_GET["to_bob"][0]!="" )
{
	$prim_roots=array(
	2=>array(1),
3=>array(2),
5=>array(2 ,3),
7=>array(3 ,5),
11=>array(2 ,6, 7, 8),
13=>array(2 ,6 ,7 ,11),
17=>array(3 ,5 ,6, 7 ,10, 11, 12, 14),
19=>array(2 ,3 ,10, 13 ,14 ,15),
23=>array(5 ,7 ,10 ,11, 14 ,15 ,17, 19, 20, 21),
29=>array(2 ,3, 8 ,10, 11 ,14 ,15 ,18, 19 ,21, 26, 27)
	);
	$b=$_GET["to_bob"];
	if (array_key_exists($b[0], $prim_roots))
	{	
		$arr2=$prim_roots[ $b[0] ];
		if(in_array($b[1], $arr2) and is_numeric($b[2]) and $b[2]<$b[0] )
		{
			$var0=1;
			$XB2=$arr2[0];
			$YB2=pow($b[1],$XB2)%$b[0];
			$key2=pow($b[2],$XB2)%$b[0];
			//echo $XB.$YB;
			echo 'q: '.$b[0].' r: '.$b[1].' YA: '.$b[2];
		}
	}
	if($var0==0)
	{
		echo 'Invalid numbers. <br/>';$monitor->update(CHALLENGE_FAILURE);
	}	
}	
if ($var0==0)
{
	echo '<form>q: <input type="text" size="1" name="to_bob[]" style="width: 30px"/>
	r: <input type="text" name="to_bob[]" style="width: 30px"/>
	YA: <input type="text" name="to_bob[]" style="width: 30px"/>
	<input type="hidden" name="intercept" value="1"/>
	<input type="hidden" name="to_alice" value="'.$_GET["to_alice"].'"/>
	<input type="submit" value="Send"/></form>';
}
?>
</td>
<td><img src="alice.png"/></td>
</tr>
<tr>
<td><img src="alice.png"/></td>
<td><img src="1lt.png"/><br/>
<?php
$var1=0;
if(isset($_GET["to_alice"]) and $_GET["to_alice"]!="")
{
	if(is_numeric($_GET["to_alice"]) and $_GET["to_alice"]<11)
	{
	$var1=1;
	$key1=pow($_GET["to_alice"],9)%11;
	echo 'YB: '.$_GET["to_alice"];
	}
	else
	{
		echo 'Invalid YB';$monitor->update(CHALLENGE_FAILURE);	
	}
}	
if($var1==0)
{
	echo '<form>YB: <input type="text" name="to_alice" style="width: 30px" />	<input type="hidden" name="intercept" value="1"/><input type="hidden" name="to_bob[]" value="'.$_GET["to_bob"][0].'"/><input type="hidden" name="to_bob[]" value="'.$_GET["to_bob"][1].'"/><input type="hidden" name="to_bob[]" value="'.$_GET["to_bob"][2].'"/><input type="submit" value="Send"/></form>';
}
?>
</td>
<td><img style="width:128" src="eve.png"/></td>
<td>
<?php
if($var0==1)
{
?>
<img src="2lt.png"/><br/> YB: <?php echo $YB2; } ?>
</td>
<td><img src="alice.png"/></td>
</tr>
<?php }

 ?>
</table>
<?php
if($var0==1 and $var1==1)
{	
	//echo $key1.' '.$key2;
	if(isset($_GET["key1"]) and isset($_GET["key2"]))
	{	
		if($_GET["key1"]==$key1 and $_GET["key2"]==$key2)
		{
		$monitor->update(CHALLENGE_SUCCESS);
		echo '<h1>Congratulations!!</h1>';
		}
		else
		{
			echo '<h3>Wrong Keys</h3>';
			$monitor->update(CHALLENGE_FAILURE);
		}
	}
	echo '<center> <br/>You have successfully imparted 2 separate keys between Alice and Bob by acting as Man-In-Middle. <br/> 
	Now, calculate the keys Key1 and Key2.<br/><form>
	Key1: <input type="text" id="key1" name="key1" /><br/>
	Key2: <input type="text" id="key2" name="key2" />
	<br/> <input type="submit" value="Verify Keys"/> 
	<input type="hidden" name="intercept" value="1"/><input type="hidden" name="to_bob[]" value="'.$_GET["to_bob"][0].'"/><input type="hidden" name="to_bob[]" value="'.$_GET["to_bob"][1].'"/><input type="hidden" name="to_bob[]" value="'.$_GET["to_bob"][2].'"/><input type="hidden" name="to_alice" value="'.$_GET["to_alice"].'"/>
	</form></center>

	';
}
}
?>
</body>
</html>
