<!-- YOU ARE NOT ALLOWED TO GO THROUGH THIS SCIPRT, IT CONTAINS THE CREDENTIALS, TRY HARDER IF YOU ARE A REAL SECURITY ENTHUSIAST, [THIS FILE WILL NEVER BE AVAILABLE TO YOU WHILE YOU ARE TESTING WEB APPLICATIONS ONLINE]
SO TRY HARDER   -->

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Admin Page</title>
<div>
  <body background=""><center/>
  <div/>
<?php 

	$flag = $_POST["flag"];

	//print_r($_POST);

	if ($flag == "PIKACHU") {
     
		echo "<br/><br/><br/><br/><center><font size = 4 color=black><b>Congratulations :D<br/><br/>You NAILED IT !<b/></font>";
		
		die();
	}
  	
	else
	{

	echo "<br/><br/><br/><br/><center><font size = 4 color=black><b>Nice Try <br/><br/> Invalid Username/Password. Try Again !!<b/></font>"; 

		die();
    }

?>


<html/>
