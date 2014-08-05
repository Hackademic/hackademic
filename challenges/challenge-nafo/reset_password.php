<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");
require_once('constants.php');

$solution = 'okamangar';
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

$valid_id = false;
$message = new Message('Incorrect URL.', Message::ERROR);
$id = 0;
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
	$id = $_GET['id'];
	if(isset($_POST['password'])) {
	// Submitted form with new password.
		if($id == $_SESSION['forgotten_password_id_jsmith']) {
			$message = new Message('The password for John Smith has been updated.', Message::SUCCESS);
		} else if($id == $_SESSION['forgotten_password_id_okamangar']) {
			$message = new Message('The password for Omid Kamangar has been updated.', Message::SUCCESS);
			$answer = $_POST['password'];
			$validator->validateSolution($answer);
		}
	} else {
		if($id == $_SESSION['forgotten_password_id_jsmith'] || 
			$id == $_SESSION['forgotten_password_id_okamangar']) {
			$valid_id = true;
		} else {
		// Incorrect id => fails challenge.
			$validator->failChallenge();
		}
	}
} else {
// The user tried something with the URL... and failed :P
	$validator->failChallenge();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>DARPA NAFO Website - Private Area</title>
	<link rel="icon" href="data/logo.png"/>
	<link rel="stylesheet" href="data/bootstrap.min.css"/>
	<link rel="stylesheet" href="data/style.css"/>
	<!--[if lt IE 9]>
		<script type="text/javascript" src="data/html5.js"></script>
	<![endif]-->
	<script type="text/javascript" src="data/jquery.min.js"></script>
	<!--[if IE]>
		<script type="text/javascript" src="data/placeholder.js"></script>
	<![endif]-->
	<script type="text/javascript" src="data/alert-message.js"></script>
	<script type="text/javascript">
		// Cookies need to be activated.
		if(!navigator.cookieEnabled) alert('You need to activate cookies to authenticate yourself.');
	</script>
</head>
<body onload="document.getElementById('login').focus();">
	<a href="."><img src="data/logo.png" alt="NAFO" title="NAFO" id="logo"/></a>
	<header>
		<h1><a href="/index.php">DARPA NAFO Website - Private area</a></h1>
	</header>
	<nav id="slave">
		<ul>
			<li>
				<a href="#">Home</a>
			</li>
			<li>
				<a href="#">Careers</a>
			</li>
			<li>
				<a href="#">Contact</a>
			</li>
			<li>
				<a href="#">Introduction</a>
			</li>
			<li>
				<a href="#">Partners</a>
			</li>
			<li>
				<a href="#">News</a></li>
			<li>
				<a href="#">Presentations</a>
			</li>
			<li>
				<a href="#">Publications</a>
			</li>
			<li>
				<a href="#">DARPA</a>
			</li>
			<li>
				<a href="#">Help</a>
			</li>
		</ul>
	</nav>
	<section id="page">
		<nav id="master">
			<ul>
				<li>
					<a href="index.php">PRIVATE AREA</a>
				</li>
			</ul>
		</nav>
		<section id="body">
		<?php
			if(!$valid_id) {
				// Error/Success message (Incorrect URL or Password changed):
				echo '<p class="alert alert-'.$message->getLevel().'">';
				echo $message->toString().'</p>';
			} else {
		?>
			<form id="form" method="post" id="change_password_form" class="row">
				<fieldset class="well span6">
				<h3>Change your password</h3>
					<input type="hidden" name="id" value="<?= $id ?>">
					<input type="password" id="password" name="password" placeholder="New password"/><br/>
					<button class="btn btn-primary" type="submit"><i class="icon-white icon-ok"></i>&nbsp;&nbsp;Change</button>&nbsp;&nbsp;&nbsp;
				</fieldset>
			</form>
		<?php
			}
		?>
		</section>
	</section>
</body>
</html>
