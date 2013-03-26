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
<meta http-equiv="Content-Language" content="en-us">
<meta name="generator" content="Bluefish 2.0.2" >
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1253">
<title>Challenge 001</title>
<style type="text/css">
.style2 {
	font-size: xx-large;
	color: #0000FF;
}
.style3 {
	color: #808000;
}
</style>
</head>

<body >
	<?php
			include_once dirname(__FILE__).'/../../../init.php';		
        session_start();
        require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
         $monitor->update(CHALLENGE_INIT,$_GET['user'],$_GET['id'],$_GET['token']);

	 ?>
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="101%" id="AutoNumber1" height="104">
  <tr>
    <td width="85%" height="104">
    <div style="background-color: #C0C0C0">
     <p align="center"><img border="0" src="logo2.gif" width="26" height="25"><span lang="el" class="style2">GREEK LOGISTICS COMPANY</span><img border="0" src="logo2.gif" width="26" height="25"><b><font size="7" color="#0000FF"><span lang="el"><br>
      </span></font></b><span lang="el"><font size="2" color="#FF0000">We are the first company in Greece since 1990 that offer human transportation through the </font></span><font size="2" color="#FF0000"> internet</font></div>
    </td>
  </tr>
</table>
<p><i><span class="style3"><span lang="el">Anonymous Corporation since 1990. Reg. No: K7827-232-210B/1990</span></span><b><font color="#808000"> </font> <font color="#FFFFFF"><span lang="el"> </span>white, rabbit</font></b></i></p>
<form action="./main/index.php" method="post">
  <p align="center">Enter Code / Password
    <input type="text" name="name1" size="20">
  <input type="text" name="name2" size="20">

  </p>

  <p align="center">
  <input type="hidden" value=<?php echo  $name1 ?> name="name1">
  <input type="hidden" value=<?php echo  $name2; ?> name="name2">

  <input type="submit" name="submit" value="Enter!">
  </p>
</form>
<p align="left"><b><span><i>Enter code and password to enter the transportation system.</i></span><i></span></i></b></p>

<p align="left"> </p>

</body>


</html>
