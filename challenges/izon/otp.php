<?php
	/* Start the session in order to access its variables */
	session_start();
	/* If the user left the otp field empty, we have to redirect him back with an error */
	if (!isset($_POST['otp'])) {
		header("Location: index.php?error=8");
		die();
	}
	/* OTP is valid for 180 second (3 min) since initialized.
	We check $_SESSION['ch04_stamp'] which contains the timestamp when the challenge initialized/reseted
	against the current timestamp for expiration */
	$stamp = $_SESSION['ch04_stamp'];
	if ((time() - $_SESSION['ch04_stamp']) > 180) {
		header ("Location: index.php?error=9");
		die();
	}
	/* Calculate the username */
	$username = hash('crc32', $_COOKIE['PHPSESSID']);
	/* and keep its first two characters */
	$otp = substr($username, 0, 2);
	/* Moreover, reconstruct the date from the stored timestamp, get the Hour it was 
	calculated, multiply it by four (4) and make sure it always has two digits (04, 08 etc) */
	$otp .= sprintf("%1$02d", (date("H", $_SESSION['ch04_stamp'])*4));
	/* Same goes for minutes, we get them from the stored timestamp and add 32 to the value */
	$otp .= (date("i", $_SESSION['ch04_stamp'])+32);
	/* If the provided by the user OTP is the one calculated, then send him back to index, and 
	set values to 'ch04' and 'ch04_timer' session variables (in order for the script to be aware
	that the challenge is complete). */
	if ($_POST['otp'] == $otp) {
		$_SESSION['ch04']=1;
		$_SESSION['ch04_timer']=time();
		header("Location: index.php");
		die();
	} else {
		header("Location: index.php?error=9");
		die();
	}
?>