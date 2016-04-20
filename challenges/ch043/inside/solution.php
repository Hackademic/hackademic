<!-- YOU ARE NOT ALLOWED TO GO THROUGH THIS SCIPRT, IT CONTAINS THE CREDENTIALS, TRY HARDER IF YOU ARE A REAL SECURITY ENTHUSIAST, [THIS FILE WILL NEVER BE AVAILABLE TO YOU WHILE YOU ARE TESTING WEB APPLICATIONS ONLINE]
SO TRY HARDER   -->

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Admin Page</title>
<div>
  <body background="../images/sad.jpg"><center/>
  <div/>
<?php 

	$usr = $_POST["user"];
	$pass = $_POST["pwd"];

	if ($usr==='theadmin' and $pass==='theadmin123') {
     
		echo "<br/><br/><br/><br/><center><font size = 7 color=Green><b>Congratulations :D<br/><br/>You NAILED IT !<b/></font>";
		
		die();
	}
  	
	else
	{

	echo "<br/><br/><br/><br/><center><font size = 7 color=Red><b>Nice Try.. <br/><br/> Invalid Username/Password. Try Again !!<b/></font>"; 

		die();
    }

?>


<html/>
