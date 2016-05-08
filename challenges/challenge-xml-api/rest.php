<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = true;
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

libxml_use_internal_errors(true);

$success = false;
if(isset($_POST['data']) && !empty($_POST['data'])) {
	if(strlen($_POST['data']) > 1000) {
	// We only allow 1000 characters.
		exit('The XML document you\'ve submitted is too big. Please enter an other one.');
	}

	$result = simplexml_load_string($_POST['data']);
	if($result === false) {
		$errors = libxml_get_errors();
		$excessiveDepth = false;
		foreach($errors as $error) {
			$errorMessage = trim($error->message);
			if($errorMessage == 'Detected an entity reference loop') {
			// Billion laughs attack.
				$success = true;
			} else if(preg_match('/Excessive depth in document:/', $errorMessage)) {
			// Error message concerning an excessive depth.
				$excessiveDepth = true;
			} else if($excessiveDepth && $errorMessage == 'Entity \'xxe\' failed to parse') {
			// A successfull attack needs an excessive depth in an external entity.
				$success = true;
			} else {
			// Other error means it's a failed attempt.
				$success = false;
				break;
			}
		}
	}
}

if($success) {
	sleep(20);
	$validator->validateSolution($success);
} else {
	$validator->failChallenge();
}

?>