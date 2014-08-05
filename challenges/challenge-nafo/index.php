<?php

session_start();

require_once('constants.php');

// Initialisation of other variables:
$message = null;
$message_forgot = null;

if(isset($_POST['password']) && isset($_POST['login'])) {
// Authentication form has been submitted:
	$password = $_POST['password'];
	$login = $_POST['login'];
	if($login == 'okamangar' || $login == 'jsmith') { // Omid Kamangar and John Smith
		$message = new Message('Wrong Password.', Message::ERROR);
	} else {
		$message = new Message('This user doesn\'t exist in the database.', Message::ERROR);
	}

} elseif(isset($_POST['email'])) {
// Forgotten password form has been submitted:
	if($_POST['email'] != '') {
		if($_POST['email'] == 'okamangar@darpa.gov' || $_POST['email'] == 'jsmith@darpa.gov') {
			if(!isset($_SESSION['counter'])) {
				$_SESSION['counter'] = rand(1000000, 9000000);
				$_SESSION['forgotten_password_id_okamangar'] = 0;
				$_SESSION['forgotten_password_id_jsmith'] = 0;
			}
			// The counter is only incremented.
			$_SESSION['counter']++;
			if($_POST['email'] == 'okamangar@darpa.gov') {
				$_SESSION['forgotten_password_id_okamangar'] = $_SESSION['counter'];
			} else {
				$_SESSION['forgotten_password_id_jsmith'] = $_SESSION['counter'];
				// This is our account so we'll receive an email notification.
				$_SESSION['new_email'] = true;
			}
		} else {
			$message_forgot = new Message('There is no user with this email address in the database.', Message::ERROR);
		}
	} else {
		$message_forgot = new Message('Email field required.', Message::ERROR);
	}
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
	<script type="text/javascript">
		function show_forgot_form() {
			$("#forgot_form").show("slow");
			$("#email").focus();
		}
	</script>
	<script type="text/javascript" src="data/alert-message.js"></script>
	<script type="text/javascript">
		// Cookies need to be activated.
		if(!navigator.cookieEnabled) alert('You need to activate cookies to authenticate yourself.');
	</script>
	<?php
		if(isset($_SESSION['new_email']) && $_SESSION['new_email']) {
	?>
		<script type="text/javascript">
			$(function() {
				$('#new_email').delay(1000).show('blind');
			});
		</script>
	<?php
		}
	?>
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
			<form method="post" <?php if($message_forgot=='') echo 'style="display:none;"'; ?> id="forgot_form" class="row">
				<fieldset class="well span6">
				<h3>Forgotten password</h3>
					<input type="text" name="email" id="email" placeholder="Email"/><br/>
					<?php 
					if($message_forgot != null) {
						echo '<p class="alert alert-'.$message_forgot->getLevel().'">'.$message_forgot->toString().'</p>';
					}
					?>
					<button class="btn btn-primary" type="submit"><i class="icon-white icon-envelope"></i>&nbsp;&nbsp;Send email</button>
				</fieldset>
			</form>
			<form id="form" method="post" id="login_form" class="row">
				<fieldset class="well span6">
				<h3>Authentification</h3>
					<input type="text" id="login" name="login" value="" placeholder="Login"/><br/>
					<input type="password" id="password" name="password" placeholder="Password"/><br/>
					<?php 
					if($message != null) {
						echo '<p class="alert alert-'.$message->getLevel().'">'.$message->toString().'</p>';
					}
					?>
					<button class="btn btn-primary" type="submit"><i class="icon-white icon-ok"></i>&nbsp;&nbsp;Login</button>&nbsp;&nbsp;&nbsp;
					<a style="font-size:small;" href="#" onclick="show_forgot_form();">Forgot your password?</a>
				</fieldset>
			</form>

			<?php
				if(isset($_SESSION['new_email']) && $_SESSION['new_email']) {
			?>
			<a href="mail.php" id="new_email" style="display:none;" onclick="javascript:void window.open('mail.php','1407178481466','width=700,height=500,status=1,scrollbars=1');return false;">
			<div id="new_email_box">
				<img src="data/new_email.svg" width="100px" style="float: left; margin: 10px;">
				<img src="data/close.png" width="20px" style="float: right;" onclick="$('#new_email').attr('onclick', '').attr('href', '#'); $('#new_email').remove(); return true;">
				<b>[DARPA NAFO] Reset your password</b>
				<hr style="border: solid 1px grey">
				<b>You are receiving this email because you...</b>
				<!--<a href="mail.php" onclick="javascript:void window.open('mail.php','1407178481466','width=700,height=500,status=1,scrollbars=1');return false;">Pop-up Window</a>-->
			</div>
			</a>
			<?php
				}
			?>
		</section>
	</section>
</body>
</html>
