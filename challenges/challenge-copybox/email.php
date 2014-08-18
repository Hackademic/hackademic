<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

// Regex to check the solution submitted.
// The body of the email must contain an image with a GET request to delete the folder.
$urlInRegex = 'http:\/\/.+?\/challenge-copybox\/ajax\.php\?type=delete&selected=\[%22Blackmails%22\]';
$solution = new RegexSolution('<img\s(\s*\w+=".+?")*\s*src="'.$urlInRegex.'"(\s*\w+=".+?")*\/?>');
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

$message = '';
if(isset($_POST['to']) && isset($_POST['subject']) && isset($_POST['email'])) {
	$message = 'The email has been sent!';
	if(trim($_POST['subject']) == 'Job offer in London') {
		if(trim($_POST['to']) == 'thomas.allingham@opponentcompany.com') {
			$validator->validateSolution($_POST['email']);
		} else {
			$validator->failChallenge();
		}
	} else {
		$validator->failChallenge();
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>CopyBox</title>
	<link rel="icon" href="data/icon.png"/>
	<link href="data/style.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="data/jquery-1.11.1.min.js"></script>
	<script type="text/javascript">
		$(function() {
			// Account menu on the top right:
			$('#my-account-settings').click(function() {
				$(this).prev().toggle();
				$(this).next().toggle();
			});
		});

		function serviceUnavailable() {
			alert('The service is unavailable at the moment. Please try again later.');
		}
	</script>
</head>
<body class="fr ui-selectable">
	<div id="browser-header">
		<div class="browser-container" id="browser-account">
			<div class="browser-container-inner">
				<div class="Fleft browser-unselectable">
					<a href="index.php" title="CopyBox - Be safe, make a copy!" class="Fleft logo">
						<img src="data/logo.png" width="100">
					</a>
				</div>
				<div class="Fright browser-my-account browser-unselectable">
					<div class="ui-group">
						<i class="ui-arrow ui-arrow-inverse"></i>
						<a id="my-account-settings" href="#" class="my-account bold" tabindex="-1">
							John&nbsp;Smith<br>
							<span class="small white" id="browser-used-space-text">3,72 Go (18,60%)</span>
						</a>
						<ul class="ui-menu account-menu">
							<li>
								<a href="#" onclick="serviceUnavailable();" class="browser-account-menu-item browser-account-menu-target browser-account-menu-account">My account</a>
							</li>
							<li>
								<a href="#" onclick="serviceUnavailable();" class="browser-account-menu-item browser-account-menu-target browser-account-menu-backups">My backups</a>
							</li>
							<li>
								<a href="#" onclick="serviceUnavailable();" class="browser-account-menu-item browser-account-menu-language">Change language</a>
							</li>
							<li>
								<a href="#" onclick="serviceUnavailable();" class="browser-account-menu-item browser-account-menu-logoff">Log out</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="browser-container" id="browser-breadcrumb">
			<ul class="browser-container-inner">
				<li class="top browser-unselectable ui-droppable">
					<a href="#" class="top-link">CopyBox</a>
				</li>
			</ul>
		</div>
		<form id="email-form" method="post">
			<?php
				if($message != '') {
				// The form has been submitted.
					echo '<p class="message">'.$message.'</p>';
				} else {
			?>
			<label for="subject">To:</label>&nbsp;&nbsp;&nbsp;
			<input type="text" name="to" value="thomas.allingham@opponentcompany.com"><br/>
			<label for="subject">Subject:</label>&nbsp;&nbsp;&nbsp;
			<input type="text" name="subject" value="Job offer in London"><br/>
			<textarea name="email">Hi,

I hope you're well,

I am currently working on the behalf of a number of innovative companies in London who are seeking a skilled Scala developer/software programmer with this obvious passion.
I have just had a new role become active with one of my largest clients.
They are a mobile augmented reality advertising company.
They are looking for both a Mid Level and Senior Java developer to join their team and work on some of their exciting new and innovative projects, also learning Grails.
There is also the chance to learn NoSQL, such as Hadoop, Pig or Oozie.

<b>Position 1: Based in Central London (£65-75k)</b>

One of the biggest broadcasting companies in the world who are very agile, they love XP and TDD and are looking for some talent Scala agile developers to join their team.
They are looking for talented developers to work on their Back End applications and to contribute to their fun, full lifecycle development experience.

<b>Position 2: Based in Central London (£50-65k)</b>

This company is a software as a service company specialising in unified email management.
They help organizations and businesses of all sizes to protect their users and data from security threats, and to archive all their human-generated data - from voice, through email, to files and IM - in a compliant, cloud-based archive.

If you would be interested in these opportunities or intrigued to hear details of other roles (both Front and Back End) please get in touch.
I am able to provide as much information on request as possible and look forward to hearing from you.


Best wishes,

Dom Smith
Managing Consultant
+44 (0)79 4268 5642</textarea><br/>
			<a href="#" onclick="$(this).closest('form').submit();">Send</a>
			<?php 
				}
			?>
		</form>
	</div>
	<div id="browser-footer" class="browser-container">
		<div class="browser-container-inner">
			<div class="Fleft">
				<a href="#" class="browser-unselectable">CopyBox</a>
			</div>
			<div class="Fright">
				<a href="#" class="browser-unselectable">Copyright 2014</a>
				&nbsp;|&nbsp;
				<a href="#" class="browser-unselectable">Legal notice</a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div id="vakata-contextmenu"></div>
</body>
</html>
