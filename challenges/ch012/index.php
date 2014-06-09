<?php
/** 
 *    ----------------------------------------------------------------
 *    OWASP Hackademic Challenges Project
 *    ----------------------------------------------------------------
 *    Copyright (C) 2010-2011 
 *   	  Andreas Venieris [venieris@owasp.gr]
 *   	  Anastasios Stasinopoulos [anast@owasp.gr]
 *    ----------------------------------------------------------------
 */
?>

<?php
include_once dirname(__FILE__).'/../../init.php';

session_start();

require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");

$monitor->update(CHALLENGE_INIT, $_GET);

$_SESSION['init'] = true;


	if(isset($_POST['query']))
	{
		$result =  $_POST['query'];
		if (strlen($result)>=40 and (substr($result,24,16)=='\x94\x05\x40\x00') )
		{
			if (str_replace("\\x00", "",substr($result,40,16) )=="")
			{
				$monitor->update(CHALLENGE_SUCCESS);
				echo "<h1><br><center> All Accounts, Account details deleted successfully. Congratulations. <br/></center></h1>";
			}
		
			else
			{
							$monitor->update(CHALLENGE_FAILURE);
				echo "<h1><br><center>Your query has been recorded. We'll reply back to you.<br /></cetner></h1>";
			}
		}
		
		else
		{
						$monitor->update(CHALLENGE_FAILURE);
			echo "<h1><br><center>Your query has been recorded. We'll reply back to you.<br /></cetner></h1>";
		}
	}
	
?>

﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta http-equiv="Content-Language" content="en-us" />
<title>Challenge 012</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>



<body style="background-color: green">
<h1><center>Finance Helper.com.<br /></cetner></h1>
<img style="margin-left:100px;float:right" width="300"  src="help.jpg" />  <br /><br />

<form style="margin-left:100px;" method="post">
	<legend>We are here to help you. Ask your query:</legend>
	 
	<textarea name="query" rows="10" cols="50" /> </textarea><br />
	<br />
	<input name="Button1" type="submit" value="Submit"  /> <br />
</form>
<br /><br /><br /><br />
Note: We accept any kind of quiries, in any language. Like you can ask in english,german,french,latin,hindi..., You can even ask in hexadecimal format, for example, \xHH  means byte with hexadecimal value HH. We assure you we will understand it. 
</body>
</html>
