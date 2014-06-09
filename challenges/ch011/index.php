<?php
/** 
 *    ----------------------------------------------------------------
 *    OWASP Hackademic Challenges Project
 *    ----------------------------------------------------------------
 */
?>
<!--CheckMyLuck.com 
We make you rich instantly. We have developed a fully functional program named checkmyluck.c that decides your luck,
 your coupon number is given as an input to that program. The program is so built that fortune always favours you. Good Luck!!  -->

 <?php
 include_once dirname(__FILE__).'/../../init.php';

 session_start();

 require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");

 $monitor->update(CHALLENGE_INIT, $_GET);

 $_SESSION['init'] = true;

	if(isset($_POST['coupon_number']))
	{
		$result =  $_POST['coupon_number'];

		if (strlen($result)>12 and ( str_replace('0', '', substr($result,12,4) )!="" ) )
		{
			$monitor->update(CHALLENGE_SUCCESS);
			echo "<h1><br><center>Congratulations, You have won a jackpot!!<br/></cetner></h1>";
		}
		else
		{	
			$monitor->update(CHALLENGE_FAILURE);
			echo "<h1><br><center>You are not the lucky winner. Better luck next time.<br /></cetner></h1>";
		}
	}
	
?>

﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta http-equiv="Content-Language" content="en-us" />
<title>Challenge 011</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>



<body style="background-color: yellow">

<img style="margin-left:100px"  src="lucky_draw1.jpg" width="500px"/>  <br /><br />

<form style="margin-left:150px" method="post">
	<legend>Enter the 10 digit Coupon Number:</legend>
	<input name="coupon_number" type="text" maxlength="10" /><br />
	<br />
	<input name="Button1" type="submit" value="Check My Luck"  /> <br />
</form>

</body>
                                                                                                                                                                                                           																																																																														<!-- read the file checkmyluck.c file -->
</html>
