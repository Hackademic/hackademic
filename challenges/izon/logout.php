<?php
	/* If $_COOKIE['izon'] has a value then : */
	if (isset($_COOKIE['izon'])) {
			/* Delete it, by giving an empty value and making it expire before the current time */
			setcookie('izon', '', time()-1);
	}
	/* Then redirect us back to index */
	header("Location: index.php");
	die();
?>

