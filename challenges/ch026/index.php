<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 26</title>
</head>
<?php
include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;
?>
<body bgcolor="#FFFFCC" style="">
<h1 align="center" id="heading1" style="color:brown">Man In the Middle</h1>
<style>
td{padding:15px}
</style>
<table width="85%" align="center" style="text-align:center;">
<tr>
<th>Alice</th>
<th></th>
<th>Eve (Yourself) </th>
<th></th>
<th>Bob</th>
</tr>
<tr>
<td><img src="alice.png"/></td>
<th><h3 style="color:green"> KEY 1</h3>58ad36a3a88352fae339bfb9fe0de1d3</th>
<td><img style="width:128" src="eve.png"/></td>
<th><h3 style="color:#8F3107"> KEY 2</h3>fd7941b217a308461b6ec046aaf9060b</th>
<td><img src="alice.png"/></td>
</tr>
<tr>
<td><img src="alice.png"/></td>
<td><img src="1rt.png"/><br/>JGNNQ FGCT YJGP UJCNN DG DGIKP VJG CVVCEM</td>
<td><img style="width:128" src="eve.png"/></td>
<td><img src="2rt.png"/><br/>
<?php 
$var1=0;
$cipher1="NKRRU JKGX CNKT YNGRR HK HKMOT ZNK GZZGIQ";
if(isset($_GET["cipher1"]) and $_GET["cipher1"]==$cipher1)
{	
	$var1=1;
	echo $cipher1;
}
else
{
	if(isset($_GET["cipher1"]))
	{
		$monitor->update(CHALLENGE_FAILURE);
	}
	echo '<form><input type="text" name="cipher1" /><input type="submit" value="Send"/></form>';
}
?>
</td>
<td><img src="alice.png"/></td>
</tr>
<?php
if($var1==1)
{
?>
<tr>
<td><img src="alice.png"/></td>
<td><img src="1lt.png"/><br/>
<?php 
$cipher2="NGVU DGIKP GCTNA KP VJG OQTPKPI VQOQTTQY CV IJCKKV TQCF";
if(isset($_GET["cipher2"]) and $_GET["cipher2"]==$cipher2 and $var1=1)
{	
	echo $cipher1;
	$monitor->update(CHALLENGE_SUCCESS);
	echo '<script>document.getElementById("heading1").innerHTML+="<br/>Congratulations!!"</script>';
}
else
{
	if(isset($_GET["cipher2"]))
	{
		$monitor->update(CHALLENGE_FAILURE);
	}
	echo '<form><input type="text" name="cipher2" /><input type="hidden" name="cipher1" value="'.$cipher1.'"/><input type="submit" value="Send"/></form>';
}
?>
</td>
<td><img style="width:128" src="eve.png"/></td>
<td><img src="2lt.png"/><br/>RKZY HKMOT KGXRE OT ZNK SUXTOTM ZUSUXXUC GZ MNGOOZ XUGJ</td>
<td><img src="alice.png"/></td>
</tr>
<?php
}
?>
</table>

</body>
</html>
