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
	/*	include_once dirname(__FILE__).'/../../init.php';		
        session_start();
        require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
        $monitor->update(CHALLENGE_INIT,$_GET['user'],$_GET['id'],$_GET['token']);
*/
$mystring = $_POST["name"]; 
if ($mystring === 'Irene'){

//if(!isset($_COOKIE["userlevel"] ) and ($_POST["name"]==='Irene') ){
//} 

	setcookie("username", 'Irene'); // set the cookie for 1 hour
	setcookie("userlevel", 'user'); // set the cookie for 1 hour
	if ($_COOKIE["userlevel"] ==='admin' ){
			echo "<H1>Congratulations!</H1>";
			$monitor->update(CHALLENGE_SUCCESS);
	}


//echo "==>".$_POST["name"];
//echo "<br>==>".$_COOKIE["userlevel"];
	
?> 

<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

	<head>

	<style type="text/css">
<!--
body {
	background-image: url(index_files/background.jpg);
}
.style1 {color: #0000FF}
-->
    </style>
<title>Challenge 007</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1253">
	<meta http-equiv="Content-Language" content="el">
</head>

<body bgcolor="#C0C0C0">
	
	<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="101%" id="AutoNumber1" height="104" background="spoudastes/Banner01.bmp">
	  <tr>
	    <td width="86%" height="104">
	    <p align="center"><img src="index_files/logo.png">
<p align="center"><strong><font color="#FFFF00" size="7"><a href="index.php"></a></font></strong></td>
	  </tr>
	</table>
	<hr><hr>
	<p><strong><span lang="el">Module Marks per Semester for:<br>
	      <span class="style1">Irene Pretty, SUN: <span class="style1">666-3-6</span></span></strong></p>
	<table border="1" cellpadding="0" cellspacing="0" width="48%" id="AutoNumber2" style="border-left-style: none; border-right: .75pt solid navy; border-top: .75pt solid navy; border-bottom: .75pt solid navy; background-color: white" fpstyle="23,011111100">
      <tr>
        <td colspan="2" style="font-weight: bold; color: white; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: navy"><div align="center">1st Semester:</div></td>
      </tr>
      <tr>
        <td width="70%" style="font-weight: bold; color: white; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: navy">
        Courses</td>
        <td width="30%" style="font-weight: bold; color: white; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: navy">
          <div align="center">Grades</div></td>
      </tr>
      <tr>
        <td width="70%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white">
		Calculus I</td>
        <td width="30%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white" align="center">
        <span lang="el">E</span></td>
      </tr>
      <tr>
        <td width="70%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white">
		Digital Logic</td>
        <td width="30%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white" align="center">
        <span lang="el">FAIL</span></td>
      </tr>
      <tr>
        <td width="70%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white">
		Linear Algebra</td>
        <td width="30%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white" align="center">
        <span lang="el">FAIL</span></td>
      </tr>
      <tr>
        <td width="70%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white">
		Introduction to Programming</td>
        <td width="30%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white" align="center">
        <span lang="el">E</span></td>
      </tr>
      <tr>
        <td width="70%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white">
		Introduction to Informatics and Telecomms</td>
        <td width="30%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white" align="center">
        <span lang="el">FAIL</span></td>
      </tr>
    </table>
    <table border="1" cellpadding="0" cellspacing="0" width="48%" id="AutoNumber2" style="border-left-style: none; border-right: .75pt solid navy; border-top: .75pt solid navy; border-bottom: .75pt solid navy; background-color: white" fpstyle="23,011111100">
      <tr>
        <td colspan="2" style="font-weight: bold; color: white; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: navy; height: 12px;"><div align="center">
			2nd Semester:</div></td>
      </tr>
      <tr>
        <td width="70%" style="font-weight: bold; color: white; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: navy"> 
		Courses</td>
        <td width="30%" style="font-weight: bold; color: white; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: navy"> <div align="center">
			Grades</div></td>
      </tr>
      <tr>
        <td width="70%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white">
		Calculus II</td>
        <td width="30%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white" align="center">
		&nbsp; </td>
      </tr>
      <tr>
        <td width="70%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white">
		Physics</td>
        <td width="30%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white" align="center">
		&nbsp; </td>
      </tr>
      <tr>
        <td width="70%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white">
		Data Structures</td>
        <td width="30%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white" align="center">
		&nbsp; </td>
      </tr>
      <tr>
        <td width="70%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white">
		Object-Oriented Programming</td>
        <td width="30%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white" align="center">
		&nbsp; </td>
      </tr>
      <tr>
        <td width="70%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white">
		Electronics and their Applications</td>
        <td width="30%" style="font-weight: normal; color: black; border-left: .75pt solid navy; border-right-style: none; border-top-style: none; border-bottom: .75pt solid navy; background-color: white" align="center">
		&nbsp; </td>
      </tr>
    </table>
    <p>&nbsp;</p>
	
	</body> 	
<?php 
}
else{
               $monitor->update(CHALLENGE_FAILURE);
?>
<p>******************************************************** 
<p> ERRONEOUS IMPORT OF DATA!
<p> Please try again!
<p>********************************************************
<?php 
}
?></html>
