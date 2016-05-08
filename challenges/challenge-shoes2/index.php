<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = '..%2Fconfig.ini%00';
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

$whitelist = array('', 'index', 'men', 'women', 'kids', $solution);
$page = 'index';
if(isset($_GET['page'])) {
	if(in_array(urlencode($_GET['page']), $whitelist)) {
		$page = urlencode($_GET['page']);
		$valid = $validator->validateSolution($page);
	} else {
		include('error404.html');
		exit();
	}
}

include($page.'.html');

?>
