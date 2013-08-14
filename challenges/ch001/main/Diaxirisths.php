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
	include_once dirname(__FILE__).'/../../../init.php';
    session_start();
    require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
    if(isset($_POST['submit'])) {
		$name1 = $_POST["name1"];
		if ($name1 === 'Friday13@JasonLives.com') {
			$monitor->update(CHALLENGE_SUCCESS);
			echo "<br><br><br><br><center><font color=Green>Congratulations!</font>";
			die();
		} else {
			$monitor->update(CHALLENGE_FAILURE);
		}
	}
?>

<html>
<head>
<style type="text/css">
.style1 {
	font-family: "Times New Roman", Times, serif;
}
</style>
</head>

<font size="6">Central Communication Panel</font><b><font size="6">
		<img border="0" src="banner.gif" width="23" height="24">&nbsp;&nbsp;&nbsp; </font></b>
<body>

	<form method="POST" action="Diaxirisths.php" style="height: 250px">
		&nbsp;<p>
		  Type e-mail</span><span lang="en-us" class="style1"> </span>
		  <input type="text" name="name1" size="71"></p>
		  <p>Message</p>
		  <textarea rows="8" name="name2" cols="99" ></textarea><br>


		  <input type="submit" name="submit" value="Send">

		<p><a href="main.htm">Home</a></p>
	</form>

</body>

</html>
