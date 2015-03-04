<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 16</title>
<center>
<body bgcolor="black" style="margin-left:35px">
<img src="text_replacer.png">

<font color="white">
</head>
<body>

<h2>
<hr>
<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

?>


<form method="get" id="replacer">
Enter the text: <br/><textarea name="text" cols="30" rows="4"></textarea><br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Enter the word to find: <input id="pattern" type="text" name="pattern"/><br/><br>
Enter the word to replace with: <input type="text" name="replace_with"/><br/><br>
<input type="button" value="Replace Text" onclick="addslashes();" />
</form >

<script>
function addslashes()
{	
	document.getElementById("pattern").value='/'+document.getElementById('pattern').value+'/';
	document.getElementById("replacer").submit();
}
</script>
<?php
if(isset($_GET['text']) and isset($_GET['pattern']) and isset($_GET['replace_with']) )
{	
	list($empty, $pattern, $modifier) = split('/',$_GET['pattern']);
	$end='/';
	$replace=$_GET['replace_with'];
	if($modifier=='i')
	{	
		$end='/i';
	}
	else if($modifier=='e')
	{	
		$replace= preg_replace('/\s+/', '', $replace);
		$replace= preg_replace('/;+/', '', $replace);
		if($replace=='system("location")' or $replace=="system('location')" or $replace=='shell_exec("location")' or $replace=="shell_exec('location')" or $replace=='exec("location")' or $replace=="exec('location')")
		{
			$replace="90.0000° S, 0.0000° W";
		}
		else
		{	
			$replace="you don't have permission to execute this particular command";
		}
	}
	echo 'Your replaced text:<br/>';
	echo preg_replace('/'.$pattern.$end, $replace, $_GET['text']);
}
?>

</center>

</body>
</html>
