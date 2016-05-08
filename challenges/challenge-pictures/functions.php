<?php

/**
 * Retrieves the MIME type using finfo.
 * @param file The path to the file to analyse.
 * @return The MIME type.
 */
function getMimeType($file) {
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mimeType = finfo_file($finfo, $file);
	finfo_close($finfo);
	return $mimeType;
}

/**
 * Removes any pictures older than the session default time.
 */
function removeOldFiles() {
	// After this time, the pictures aren't binded to the users anymore.
	$ageLimit = ini_get('session.gc_maxlifetime');

	$dir = 'pictures/';
	if($handle = opendir($dir)) {
		while($file = readdir($handle)) {
			if($file != '.' && $file != '..') {
				if(time() - filectime($dir.$file) > $ageLimit) {
					unlink($dir.$file);
				}
			}
		}
	}
}

 /**
  * Deletes the previous picture uploaded by an user.
  * @param pictureId Id of the previous uploaded picture.
  */
function removePreviousPicture($pictureId) {
	$dir = 'pictures/';
	if($handle = opendir($dir)) {
		while($file = readdir($handle)) {
			if($file != '.' && $file != '..') {
				if(preg_match("/^$pictureId\.\d+$/", $file)) {
					unlink($dir.$file);
				}
			}
		}
	}
}

/**
 * Secures a file by disabling any PHP code.
 * Removes the PHP tags.
 * @param filePath The path to the file to secure.
 */
function secureFile($filepath) {
	$data = file_get_contents($filepath);
	$data = preg_replace(array('/<[\?%]/', '/[\?%]>/'), '', $data);
	file_put_contents($filepath, $data);
}

/**
 * Add the PHP code to check the challenge's solution to the end of the image file.
 * @param filepath The path to the image file.
 */
function addChallengeValidationToFile($filepath) {
	$challengeValidateCode = file_get_contents('challenge_validation.php');
	file_put_contents($filepath, $challengeValidateCode, FILE_APPEND);
}

?>