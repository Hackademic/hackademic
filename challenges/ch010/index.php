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
<body bgcolor="black">
<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
<meta http-equiv="Content-Language" content="en-us">
</head>
<?php
		include_once dirname(__FILE__).'/../../init.php';		
        session_start();
        require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
        $monitor->update(CHALLENGE_INIT,$_GET['user'],$_GET['id'],$_GET['token']);

if(isset($_POST['login']))
{
	$state = $_POST['LetMeIn'];
	$password = $_POST['password'];
	
	
	$serial=$_POST["serial"];
	if ($serial=="TRVN-67Q2-RU98-546F-H1ZT")
	{
		echo "<br><br><br><br><br><center><font color=Green>Congratulations!</font>";
	}
	
	
	
	if($password == "t3hpwn3rN1nJ4" or $state == "True"){
	    $_SESSION['pwned'] = true;
	
	echo '<script type="text/javascript">alert("%53%65%72%69%61%6C%20%4E%75%6D%62%65%72%3A%20%54%52%56%4E%2D%36%37%51%32%2D%52%55%39%38%2D%35%34%36%46%2D%48%31%5A%54")</script>';
	
	$login = '
				<html>
				<head>
				<title> [[ n1nJ4.h4x0r.CreW ]] </title>
				</head>
				<body bgcolor="black">
				<center>
				<img src="ninja_eyes.png" alt="Ninja Eyes Image">
				</center>
				<hr>
				<form method="POST" action="index.php">
				<p><font color=RED>To: </p>
				<input type="text" name="to" value="r00t@n1nj4h4x0rzcrew.com"></font>
				<p><font color=RED>Subject:</p> 
				<input type="text" name="header" value="Serial Number" ></font>
				<p><font color=RED>From:</p> 
				<input type="text" name="from"></font>
				<p><font color=RED>Serial Number:</p> 
				<input type="text" name="serial"></font>
				<input type="hidden" name="login" value="True">
				<input type="submit" name="submit" value="send"><br>
				
	
				
				<hr>
				</body>
				</html>';
	
	echo $login;
	$monitor->update(CHALLENGE_SUCCESS);
	exit();
	
	} 
	else {
		 $monitor->update(CHALLENGE_FAILURE);
	?>
	<script type="text/javascript">
	alert('Wrong Password!!\nTry harder if you wanna be a member of n1nJ4.h4x0r.CreW')
	</script>
	<?php
	}
}
?>
<html>
<head>
<title> Challenge 010 - [[ n1nJ4.h4x0r.CreW ]] </title>
</head>
<body bgcolor="black">
<center>
<img src="ninja_eyes.png">
<hr>
<form method="post" action="">
<input type="hidden" name="LetMeIn" value="False">
<input type="password" name="password">
<input type="submit" name="login" value="Login">
<h3><font color=red>...sh0w m3h y0ur n1nJ4 h4x0r sKiLlz...</h3></font>
<hr>
</form>
</center>
</body>
</html>
