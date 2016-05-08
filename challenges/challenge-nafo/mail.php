<?php

session_start();

if(!isset($_SESSION['new_email']) || !$_SESSION['new_email']) {
	exit();
}
$_SESSION['new_email'] = false;

$id = $_SESSION['forgotten_password_id_jsmith'];
$dirname = dirname($_SERVER['REQUEST_URI']);
$link = 'http://'.$_SERVER['HTTP_HOST'].$dirname.'/reset_password.php?id='.$id;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Mails</title>
	<link rel="icon" href="data/new_email.png">
</head>
<body style="padding: 20px; width: 600px">
	<div style="color: grey">
		<b>From:</b> noreply-nafo@darpa.gov<br>
		<b>To:</b> John Smith<br>
		<b>Subject:</b> [DARPA NAFO] Reset your password<br>
	</div>
	<p>
		You are receiving this email because you asked to reset your password for the DARPA NAFO Website.<br>
		You can use the following link to reset your password:<br>
		<?= $link ?><br><br>

		If you don't use this link within 24 hours, it will expire.<br><br>

		Thanks,<br>
		NAFO Team<br>
	</p>
</body>
</html>