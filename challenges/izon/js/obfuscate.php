<?php
	/*εδώ ο κώδικας είναι απλός. ξεκινάμε το session και αν ο χρήστης έχει περάσει την 
	πρώτη και δεύτερη δοκιμασία, με το που βρίσκει το αρχείο, ενημερώνουμε πως πέρασε και την
	τρίτη (με χρήση του $_SESSION['ch03'] και τον γυρνάμε πίσω στο index.php */
	session_start();
	
	if ( (isset($_SESSION['ch01'])) && (isset($_SESSION['ch02'])) ) {
		$_SESSION['ch03']=1;
		$_SESSION['ch03_timer']=time();
	}  
	
	header("Location: ../index.php");
?>