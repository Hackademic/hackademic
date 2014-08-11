<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = true;
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Send POST request to the API</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script src="data/bootstrap.min.js"></script>
	<link href="data/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>
	<form method="post" action="rest.php">
		<div class="container">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading"><h1>Send POST request to the API</h1></div>
					<div class="panel-body">
						<div class="col-lg-10">
							<div class="row">
								<div class="col-lg-6">
									<label for="privkey">Data parameter</label><br>
									<small>
										<textarea name="data" rows="15" style="width:100%">
<?xml version="1.0" encoding="UTF-8"?>
<document>

</document></textarea>
									</small>
								</div>
							</div>
							<div class="row">
								<label>&nbsp;</label><br>
								<button type="submit" name="send" class="btn btn-primary">Send</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</body>
</html>
