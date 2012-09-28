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
<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><meta http-equiv="Content-Language" content="en-us"><title>LoTus7Shell</title>
</head>
<body text=#ffffff bottomMargin=0 bgColor=#000000 leftMargin=0 topMargin=0 rightMargin=0 marginheight=0 marginwidth=0><center>
<TABLE style="BORDER-COLLAPSE: collapse" height=1 cellSpacing=0 borderColorDark=#666666 cellPadding=5 width="100%" bgcolor=#000000 borderColorLight=#c0c0c0 border=1 bordercolor="#C0C0C0"><tr><th width="101%" height="15" nowrap bordercolor="#C0C0C0" valign="top" colspan="2"><p><center></p></center></th></tr>
<tr><td><h5><p align="left"><b>Software:&nbsp;Apache/2.2.16 (Fedora).  <b><u>PHP/4.4.9</u></b></a></b>&nbsp;</p><p align="left"><b>uname -a:&nbsp;Linux prwtoslagoff 2.6.34.7-61.fc13.i686 #1 SMP Tue Oct 19 04:42:47 UTC 2010 i686 </b></p><p align="left"><b>Disabled functions</b>: <b><font color=green>NONE</font></b><p align="left">cURL: <b><font color=red>OFF</font></br><b>Register globals:</b> <font color=green>ON</font><br/>MySQL: <b><font color=green>ON</font></b><br/>MSSQL: <b><font color=red>OFF</font><br/>PostgreSQL: <b><font color=red>OFF</font><br/>Oracle: <b><font color=red>OFF</font> </b>&nbsp;</p><p align="left"><b>Safe-mode:&nbsp;<font color=green>OFF (not secure)</font></b></p><p align="left"><b><font color=green>/home/slagoff/public_html </font><b><font color=green> drwxrwxrwx</font></b><br><b>Free 34.76 GB of 69.69 GB <b>
</h5>

<span style="color: green;">
<form action="tyj0rL.php" method="post">
<small><font color=red>Available Commands:</font>   (ls, id, whoami, pwd)<br>
<input name="command">
<input value="execute command" type="submit"></form>

<?php
error_reporting(0);
$com=$_POST["command"];

if (isset($com))
{
	if ($com=="ls"){echo "index.php"."<br>"."adminpanel.php"."<br>"."tyj0rL.php"."<br>"."sUpErDuPErL33T.txt";}
	elseif ($com=="whoami") {echo "<p>apache";}
	elseif ($com=="id") {echo "<p>uid=48(apache) gid=48(apache) groups=48(apache)";}
	elseif ($com=="pwd") {echo "<p>/home/slagoff/public_html";}
	elseif ($com=="") {echo "";}
	else 
	{ 
		echo "<p>bash: ".$com.": command not found"; 
	}
}
?>
<br>
<hr>
</body>
</html>
