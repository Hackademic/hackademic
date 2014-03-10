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
        session_start();
        require_once($_SESSION['hackademic_path']."pages/challenge_monitor.php");
	
	// Checking whether the GET variable 'Result' is set or not , to avoid undefined index notices.
	if(isset($_GET['Result']))
	{
		$result =  $_GET['Result'];
		if ($result === 'enter a coin to play')
		{
			echo "<h1><br><center>Congratulations!</br></cetner></h1>";
			$monitor->update(CHALLENGE_SUCCESS);
		}
		else
		{
			$monitor->update(CHALLENGE_FAILURE);
		}
	}

?>

﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>

<meta http-equiv="Content-Language" content="en-us" />
<title>Challenge 002</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="ch002.css" />
<style type="text/css">
.style1 {
	text-align: center;
}
.style2 {
	background-color: #FFFF00;
}
.style3 {
	text-align: center;
	margin-left: 193px;
	margin-right: 182px;
}
</style>
</head>

<body style="background-color: #006600">

<div id="masthead" class="style1">
	<span style="mso-ansi-language: EN-US" lang="EN-US">&nbsp;
	<h1><span style="mso-ansi-language: EN-US" lang="EN-US">
	<a href="http://www.free-images.org.uk"><img src="http://www.free-images.org.uk/military/pacific-star-medal.jpg" alt="Image: free-images.org.uk" width="100" height="170"></a>
	S/S </span>
	MILITARY SITE<span style="mso-ansi-language: EN-US" lang="EN-US">
	<a href="http://www.free-images.org.uk"><img src="http://www.free-images.org.uk/military/pacific-star-medal.jpg" alt="Image: free-images.org.uk" width="100" height="170"></a>
	<br />
	TOP SECRET AREA</span></h1>
&nbsp; </span></div>
<div id="top_nav">
	<h1 style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 0cm; PADDING-LEFT: 0cm; PADDING-RIGHT: 0cm; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 0cm; mso-border-bottom-alt: solid windowtext .5pt; mso-padding-alt: 0cm 0cm 1.0pt 0cm" align="center">
	<span style="FONT-SIZE: 8pt; mso-ansi-language: EN-US" lang="EN-US" class="style2">
	UNAUTHORISED ENTRY IS PROHIBITED AND OFFENDERS WILL BE PROSECUTED 
<o:p></o:p></span></h1>
</div>
<div id="page_content" class="style3">
	<form method="post">
		<input name="Hidden1" type="hidden" /><fieldset name="Group1">
		<legend>Enter Password</legend>
		<input name="Password1" type="password" style="width: 378px" /><br />
		<br />
		<input name="Button1" type="button" value="Enter" style="width: 95px" onclick="GetPassInfo()" /></fieldset><br />
	</form>
</div>
<div id="footer" class="style1">
	<a href="http://www.free-images.org.uk"><img src="http://www.free-images.org.uk/military/sherman-m4a1e8.jpg" alt="Image: free-images.org.uk" text="Image: free-images.org.uk" width="200" height="199"></a>
	
	<a href="http://www.free-images.org.uk"><img src="http://www.free-images.org.uk/military/mg42.jpg" alt="Image: free-images.org.uk" width="235" height="200"></a>

</div>

</body>
<script language="javascript">
		
	function GetPassInfo(){
        var madhouuuuuuuseeee = "givesacountinatoap lary"
                                

	var a = madhouuuuuuuseeee.charAt(0);  var d = madhouuuuuuuseeee.charAt(3);   var r = madhouuuuuuuseeee.charAt(16);
	var b = madhouuuuuuuseeee.charAt(1);  var e = madhouuuuuuuseeee.charAt(4);   var j = madhouuuuuuuseeee.charAt(9);     
	var c = madhouuuuuuuseeee.charAt(2);  var f = madhouuuuuuuseeee.charAt(5);   var g = madhouuuuuuuseeee.charAt(4);     
	var j = madhouuuuuuuseeee.charAt(9);  var h = madhouuuuuuuseeee.charAt(6);   var l = madhouuuuuuuseeee.charAt(11);    
	var g = madhouuuuuuuseeee.charAt(4);  var i = madhouuuuuuuseeee.charAt(7);   var x = madhouuuuuuuseeee.charAt(21);    
	var l = madhouuuuuuuseeee.charAt(11); var p = madhouuuuuuuseeee.charAt(4);   var m = madhouuuuuuuseeee.charAt(4);      
	var s = madhouuuuuuuseeee.charAt(17); var k = madhouuuuuuuseeee.charAt(10);  var d = madhouuuuuuuseeee.charAt(3);      
	var t = madhouuuuuuuseeee.charAt(18); var n = madhouuuuuuuseeee.charAt(12);  var e = madhouuuuuuuseeee.charAt(4);      
	var a = madhouuuuuuuseeee.charAt(0);  var o = madhouuuuuuuseeee.charAt(13);  var f = madhouuuuuuuseeee.charAt(5);      
	var b = madhouuuuuuuseeee.charAt(1);  var q = madhouuuuuuuseeee.charAt(15);  var h = madhouuuuuuuseeee.charAt(6);      
	var c = madhouuuuuuuseeee.charAt(2);  var h = madhouuuuuuuseeee.charAt(6);   var i = madhouuuuuuuseeee.charAt(7);      
	var j = madhouuuuuuuseeee.charAt(9);  var i = madhouuuuuuuseeee.charAt(7);   var y = madhouuuuuuuseeee.charAt(22);          
	var g = madhouuuuuuuseeee.charAt(4);  var p = madhouuuuuuuseeee.charAt(4);        
	var l = madhouuuuuuuseeee.charAt(11); var k = madhouuuuuuuseeee.charAt(10);       
	var q = madhouuuuuuuseeee.charAt(19); var n = madhouuuuuuuseeee.charAt(12);       
	var m = madhouuuuuuuseeee.charAt(4);  var o = madhouuuuuuuseeee.charAt(13);       
	
	var p = madhouuuuuuuseeee.charAt(4)
	var Wrong = (d+""+j+""+k+""+d+""+x+""+t+""+o+""+t+""+h+""+i+""+l+""+j+""+t+""+k+""+i+""+t+""+s+""+q+""+f+""+y)
	
	if (document.forms[0].Password1.value == Wrong)
		location.href="index.php?Result=" + Wrong;
	}
	

</script>

</html>
