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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php

$root=$_POST["username"];
$password=$_POST["password"];

echo '<html>'.
				  '<title>prwtoftyari.gr Administration Panel</title>'.
				  '<form method="POST" action="">'.
				  '<p><big><big>prwtoftyari.gr Administration Panel (TM)</font><hr>'.
				  '<input type="text" name="username"><br>'.
				  '<input type="password" name="password">'.
				  '<input type="submit" name="submit" value="Login">'.
				  '</form>'.
				  '</html>';

if(isset($root,$password))
{
	if (strtolower($root)=="admin" && $password=="teh_n1nj4_pwn3r")
	{
		echo "<hr><p><big><big><font color=Green>Access Granted!!! <p>Congratulations!</font>";		
	}
	else 
	{
		echo "<hr><p><big><big><font color=RED>Access Denied!</font>";
	}
}
else
{ 
	echo "<hr><p>Please login as Administrator";
}
?>
