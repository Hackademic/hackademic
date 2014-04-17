<?php
	//Αν το $_COOKIE['izon'] (δηλαδή το cookie που χρησιμοποιούμε για το Wargame
	//έχει κάποια τιμή, τότε:
	if (isset($_COOKIE['izon'])) {
			//Αχρήστευσε το cookie, δίνοντάς του κενή τιμή και ταυτόχρονα
			//λέγοντάς του πως έχει ήδη λήξει (η time() επιστρέφει το τρέχον timestamp)
			setcookie('izon', '', time()-1);
	}
	//Έπειτα, πες στον browser να ανακατευθύνει τον χρήστη στην τοποθεσία index.php
	header("Location: index.php");
	die();
?>

