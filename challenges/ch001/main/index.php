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
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = 'Friday13@JasonLives.com';
$validator = new ChallengeValidatorController($solution);

$name1 = $_POST["name1"];
$name2 = $_POST["name2"];

if ($name1==='white' and $name2==='rabbit') {

?>

<html>
<head>
<title>Challenge 001</title>
</head>

<frameset rows="124,*">
  <frame name="banner" scrolling="no" noresize src="ajv_home_page.htm" target="contents">
  <frameset cols="247,*">

    <frame name="contents"  scrolling="no" noresize src="VBanner.php" target="main" >
    <frame name="main" src="main.htm" scrolling="auto" target="_self" >

  </frameset>
  <noframes>
  <body>

  <p>This page uses frames, but your browser doesn't support them.</p>

  </body>
  </noframes>
</frameset>
	</html>


<?php

} else {
	// That's a failure.
	$validator->failChallenge();

?>
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

<html>
<h1>Wrong Code or Password!</h1>

</html>
<?php 
}
?>
