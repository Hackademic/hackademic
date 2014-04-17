<?php
	/* Code's simple here: If user has completed challenge 01 and challenge 02, then
	   we set ch03 session variable (challenge 03 complete) and in any case, we redirect the user
	   back to index */
	session_start();
	
	if ( (isset($_SESSION['ch01'])) && (isset($_SESSION['ch02'])) ) {
		$_SESSION['ch03']=1;
		$_SESSION['ch03_timer']=time();
	}  
	header("Location: ../index.php");
	die();
?>