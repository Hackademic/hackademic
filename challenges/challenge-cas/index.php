<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = 'http://legitimatewebsite.info/compromissed.html';
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

$errorMessage = '';
if(isset($_GET['username']) && isset($_POST['password'])) {
	$errorMessage = 'The information provided is incorrect. We weren\'t able to authenticate you.';
} else if(isset($_GET['service'])) {
	$answer = $_GET['service'];
	$valid = $validator->validateSolution($answer);
} else {
	// Redirects when there is no 'service' parameter
	// to make sure that the student see how this Central Authentication Service works.
	header('Location: index.php?service=http://courses.eagle-school.edu/');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<title>CAS – Central Authentication Service</title>
	<link type="text/css" rel="stylesheet" href="data/typo.css"/>
	<link type="text/css" rel="stylesheet" href="data/style.css"/>
	<script>if ( typeof window.JSON === 'undefined' ) { document.write('<script type="text/javascript" src="data/json2.js"><\/script>'); }</script>
	<script type="text/javascript" src="data/jquery.js"></script>
	<script type="text/javascript" src="data/jquery.history.js"></script>
	<script type="text/javascript">
		function login(element) {
			var username = $('#username').val();
			History.pushState(null, 'CAS - Central Authentication Service', "?username="+username);
			return true;
		}
	</script>
</head>
<body id="cas" class="fl-theme-iphone">
	<div class="flc-screenNavigator-view-container">
		<div class="fl-screenNavigator-view">
			<div id="header" class="flc-screenNavigator-navbar fl-navbar fl-table">
				<h1 id="app-name" class="fl-table-cell">Central Authentication Service (CAS)</h1>
			</div>		
			<div id="content" class="fl-screenNavigator-scroll-container">
				<form id="fm1" class="fm-v clearfix" method="post" onsubmit="login();">
					<?php
						if($errorMessage != '') {
							echo '<div style="background-color: rgb(255, 238, 221);" id="status" class="errors">'.$errorMessage.'</div>';
						}
					?>
					<div class="box fl-panel" id="login">
						<p><strong>You are accessing a service which requires authentication</strong></p>
						<p>Please enter your username and password</p>
						<div class="row fl-controls-left">
							<label for="username" class="fl-label">Username:</label>
							<input id="username" name="username" class="required" tabindex="1" accesskey="i" size="25" autocomplete="false" type="text"/>
						</div>
						<div class="row fl-controls-left">
							<label for="password" class="fl-label">Password:</label>
							<input id="password" name="password" class="required" tabindex="2" accesskey="m" value="" size="25" autocomplete="off" type="password"/>
						</div>
						<div class="row check">
							<input id="warn" name="warn" value="true" tabindex="3" accesskey="p" type="checkbox">
							<label for="warn">Notify me before accessing other services.</label>
						</div>
						<div class="row btn-row">
							<input name="lt" value="e1s1" type="hidden"/>
							<input name="_eventId" value="submit" type="hidden"/>
							<input class="btn-submit" name="submit" accesskey="l" value="Authenticate" type="submit"/>
							<input class="btn-reset" name="reset" accesskey="c" value="Clear" tabindex="5" type="reset"/>
						</div>
					</div>
				</form>
				<div id="footer" class="fl-panel fl-note fl-bevel-white fl-font-size-80"></div>
			</div>
		</div>
	</div>
</body>
</html>