<?php
	/* ξεκινάμε το session για να έχουμε πρόσβαση στις μεταβλητές του */
	session_start();
	/* αν ο χρήστης δεν έχει βάλει τίποτα στο πεδίο, τον ανακατευθύνουμε πίσω */
	if (!isset($_POST['otp'])) {
		header("Location: index.php?error=8");
		
	}
	/* Το OTP μας ισχύει για 180 δευτερόλεπτα απο την ώρα που θα πάρει τιμή. 
	Παίρνουμε το timestamp απο την $_SESSION['ch04_stamp'] (η οποία ορίζεται στο index.php)
	και ελέγχουμε αν δεν έχει "λήξει" το otp */
	$stamp = $_SESSION['ch04_stamp'];
	if ((time() - $_SESSION['ch04_stamp']) > 180) {
		header ("Location: index.php?error=9");
		
	}
	/* Βρίσκουμε το username */
	$username = hash('crc32', $_COOKIE['PHPSESSID']);
	/* και κρατάμε τα πρώτα δύο ψηφία του */
	$otp = substr($username, 0, 2);
	/* Απο την ημερομηνία του timestamp (είναι η στιγμή που το $_SESSION['ch04_stamp']
	παιρνει τιμή στο Index.php) βρίσκουμε την ώρα και την πολλαπλασιάζουμε με 4. Έπειτα 
	σιγουρευόμαστε πως έχει πάντοτε  δύο ψηφία με την χρήση της sprinf */
	$otp .= sprintf("%1$02d", (date("H", $_SESSION['ch04_stamp'])*4));
	/* Επίσης απο το timestamp παίνρουμε τα λεπτά και προσθέτουμε 32.*/
	$otp .= (date("i", $_SESSION['ch04_stamp'])+32);
	/* Αν το otp που υπολογίστηκε είναι αυτό που έδωσε ο χρήστης, τότε στείλτον πίσω στο
	Index, ενώ δίνουμε τιμές στο $_SESSION['ch04'] (είναι το flag για να ξέρουμε πως τελείωσε το challenge)
	και στο αντίστοιχο timer για να δούμε πόση ώρα έκανε ο χρήστης για να το τελειώσει */
	if ($_POST['otp'] == $otp) {
		$_SESSION['ch04']=1;
		$_SESSION['ch04_timer']=time();
		header("Location: index.php");
	} else {
		header("Location: index.php?error=9");
	}
		
	
	
	
?>