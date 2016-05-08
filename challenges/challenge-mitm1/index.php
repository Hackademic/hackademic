<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = 'true';
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

if(isset($_SESSION['validLicense'])) {
	// The validLicense session variable should be true
	// if the license has been successfully validated by the application.
	$validator->validateSolution($_SESSION['validLicense']);
	unset($_SESSION['validLicense']);
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Proxy for MITM</title>
	<link rel="stylesheet" type="text/css" href="data/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="data/style.css">
	<script src="data/jquery.min.js"></script>
	<script src="data/jquery-ui.min.js"></script>
	<script src="data/bootstrap.min.js"></script>
	<script type="text/javascript" src="data/mitm.js"></script>
</head>
<body>
	<section id="smartphone">
		<img id="smartphone_image" src="data/smartphone.png" alt="Your smartphone: click to launch the app!" title="Your smartphone: click to launch the app!">
		<img class="loading" src="data/loading.gif" alt="Receiving request..." title="Receiving request..." style="display: none;">
		<img id="access_denied" src="data/access_denied.svg" alt="Access denied" title="Access denied" style="display:none;">
		<div id="clickable_layer_smartphone"></div>
	</section>
	<section id="server">
		<img id="server_image" src="data/server.png" alt="The server for the application" title="The server for the application">
		<img class="loading" src="data/loading.gif" alt="Processing request..." title="Processing request..." style="display: none;">
	</section>
	<section id="mitm_form">
		<form class="form-horizontal" role="form">
			<div class="form-group">
				<textarea id="request_data" class="form-control" rows="15"></textarea>
			</div>
			<div class="form-group">
				<div>
					<button id="send_to_server" type="button" class="btn btn-lg btn-primary disabled">Send to server</button>
					<button id="send_to_smartphone" type="button" class="btn btn-lg btn-primary disabled">Send to smartphone</button>
				</div>
			</div>
		</form>
	</section>
</body>
</html>
