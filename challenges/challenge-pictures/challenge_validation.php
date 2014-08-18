
<?php

include_once(dirname(__FILE__).'/../../../init.php');
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = true;
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

if(isset($_SESSION['picture_infected'])) {
	$validator->validateSolution($_SESSION['picture_infected']);
} else {
	$validator->failChallenge();
}

?>