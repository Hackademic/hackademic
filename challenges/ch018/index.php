<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 17</title>
</head>

<body bgcolor style="margin-left:35px">
<center>
<img src="spell.png">

<hr width='70%'>
<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

if(isset($_POST['text']))
{
	echo 'Your text has been processed for wrongly spelled words.You can check the results <a href="spell.shtml">here</a>.<br/>';
	$txt=$_POST['text'];
	$txt_to_write='';
	if (strpos($txt,'<!--#exec') !== false) 
	{
    		$txt_to_write.= '<b>Error: Use of `exec` to execute a command is disabled<br/></b>';
	}
	if (strpos($txt,'<!--#include') !== false and strpos($txt,'key.txt') == false) 
	{
    		$txt_to_write.='<b>Permission denied: Specified file cannot be included.<br/></b>';
	}
	if (strpos($txt,'file="key.txt"') !== false or strpos($txt,"file='key.txt'") !== false ) 
	{
		$key_contents=file_get_contents('./key.txt', FILE_USE_INCLUDE_PATH);
		$txt= preg_replace('/<!--#include *file="key.txt" *-->/', $key_contents, $txt);
		$txt= preg_replace("/<!--#include *file='key.txt' *-->/", $key_contents, $txt);
	}
	$txt_to_write.="<b>Your Text:</b><br>";
	$txt_to_write.=htmlentities($txt);
	$words=explode(' ',$txt);
	$txt_to_write.="<br/><b>List of wrongly spelt words:<br/></b>";
	$i=0;
	foreach ($words as $word)
	{
		$i+=1;
		if($i%3==0 or $i%4==0)
		{
			$txt_to_write.=htmlentities($word).'<br>';
		}
	}
	file_put_contents('spell.shtml', $txt_to_write);
}

?>
<h2>
Enter the text here:<br/>
<form method="post">
<textarea name="text" rows="10" cols="100"> </textarea>
<br/><br><input type="submit" value="Spell Check"/>
</form>
</h2>
<br/><br/><br/><br/><br/>
<?php

if(isset($_POST['hash']))
{	
	if(md5_file("key.txt")==$_POST['hash'])
	{
		$monitor->update(CHALLENGE_SUCCESS);
		echo '<h2>Congratulations!!</h2><br/>';
	}
	else
	{
		$monitor->update(CHALLENGE_FAILURE);
		echo 'Invalid hash<br/><br>';
	}
}
?>
Enter the md5 hash of the key file to decrypt the messages:<br/><br/>
<form method="post">
<input type="text" name="hash" />
<input type="submit" value="Submit Hash"/>
</form>

</center>

</body>
</html>
