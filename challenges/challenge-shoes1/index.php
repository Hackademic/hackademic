<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = '../config.ini';
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

$whitelist = array('', 'index.html', 'men.html', 'women.html', 'kids.html', '../config.ini');
$page = 'index.html';
if(isset($_GET['page'])) {
	if(in_array($_GET['page'], $whitelist)) {
		$page = $_GET['page'];
		$valid = $validator->validateSolution($page);
	} else {
		include('error404.html');
		exit();
	}
}

include($page);

?>
