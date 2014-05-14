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
<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
<!-- meta content="text/html; charset=ISO-8859-1" http-equiv="content-type" -->
<!-- meta http-equiv="Content-Type" content="text/html; charset=windows-1251" -->
<meta content="text/html; charset=utf-8" http-equiv="content-type">
<meta http-equiv="Content-Language" content="en-us">
<title>trytohack.gr - LoTus7Shell - Challenge 008</title>
</head>
<body text=#ffffff bottomMargin=0 bgColor=#000000 leftMargin=0 topMargin=0 rightMargin=0 marginheight=0 marginwidth=0><center>
<TABLE style="BORDER-COLLAPSE: collapse" height=1 cellSpacing=0 borderColorDark=#666666 cellPadding=5 width="100%" bgcolor=#000000 borderColorLight=#c0c0c0 border=1 bordercolor="#C0C0C0"><tr><th width="101%" height="15" nowrap bordercolor="#C0C0C0" valign="top" colspan="2"><p><center><img src="l7s.png"></p></center></th></tr>
<tr><td><h5><p align="left"><b>Software:&nbsp;Apache/2.2.11 (Unix).  <b><u>PHP/4.4.9</u></b></a></b>&nbsp;</p><p align="left"><b>uname -a:&nbsp;Linux trytohack 2.6.9-1.667smp #1 SMP Tue Nov 2 14:59:52 EST 2004 i686</b></p><p align="left"><b>Disabled functions</b>: <b><font color=green>NONE</font></b><p align="left">cURL: <b><font color=red>OFF</font></br><b>Register globals:</b> <font color=green>ON</font><br/>MySQL: <b><font color=green>ON</font></b><br/>MSSQL: <b><font color=red>OFF</font><br/>PostgreSQL: <b><font color=red>OFF</font><br/>Oracle: <b><font color=red>OFF</font> </b>&nbsp;</p><p align="left"><b>Safe-mode:&nbsp;<font color=green>OFF (not secure)</font></b></p><p align="left"><b><font color=green>/apps/web/html/trytohack/upload_files/  </font><b><font color=green>drwxrwxrwx</font></b><br><b>Free 2.76 GB of 19.69 GB (14.05%)<b>
</h5>
<hr>
<br>
<span style="color: green;">
<form action="index.php" method="post">
<input name="command">
<input value="execute command" type="submit"></form>

<?php
error_reporting(0);
$com=$_POST["command"];
$root=$_POST["username"];
$password=$_POST["password"];

if (isset($com))
{
	if ($com=="help"){ echo ("ls"."<br>"."whoami"."<br>"."id"."<br>"."help"."<br>"."su"); }
	elseif ($com=="ls"){echo "index.php"."<br>"."b64.txt";}
	elseif ($com=="whoami") {echo "<p>apache";}
	elseif ($com=="id") {echo "<p>uid=48(apache) gid=48(apache) groups=48(apache)";}
	elseif ($com=="") {echo "";}
	elseif ($com=="su") {echo '<html>'.
				  '<form method="POST" action=""> '.
				  '<input type="text" name="username">'.
				  '<input type="password" name="password">'.
				  '<input type="submit" name="submit" value="Login">'.
				  '</form>'.
				  '</html>';}
	else
	{
		echo "<p>bash: ".$com.": command not found";
	}
}
if(isset($root,$password))
{
			include_once dirname(__FILE__).'/../../init.php';
        session_start();
        require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
        $monitor->update(CHALLENGE_INIT,$_GET);

	if ($root=="root" && $password=="g0tr00t")
	{
		echo "<p><font color=red>uid=0(root) gid=0(root) groups=0(root)</font>";
		echo "<center><p><h3><font color=green>Congratulations!</font></h3>";
		$monitor->update(CHALLENGE_SUCCESS);
	}
	else
	{
		echo "incorrect username or password";
		$monitor->update(CHALLENGE_FAILURE);
	}
}
else
{
	echo "<hr><p>Enter 'help' for available commands.<p>You need to be <font color=red>root</font> to execute most of commands.";
}
?>
<br>
<hr>
</body>
</html>
