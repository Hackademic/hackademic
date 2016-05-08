<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = new RegexSolution('^select\s+username\s*,\s*password\s+from\s+users\s*$');
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

if(isset($_GET['q'])) {
	// Simulates the WAF's answer:
	$waf_regex = '/select\s[\w+,\*\s]+\sfrom\s[\w+,\s]+/';
	if(preg_match($waf_regex, $_GET['q'])) {
		$validator->failChallenge();
		header('HTTP/1.1 501 Not Implemented');
		echo '<h1>501 Not Implemented</h1>';
		exit();
	}

	// Simulates ASP behaviour:
	// Extract the parameters (removes 'index.php?').
	$parameters = substr(basename(urldecode($_SERVER['REQUEST_URI'])), 10);
	$asp_regex = '/^q=(.+?)&q=(.+?)($|&)/';
	if(preg_match($asp_regex, $parameters, $matches)) {
		// q parameter as seen by ASP.
		$q = $matches[1].','.$matches[2];

		$key = substr($q, 0, 4);
		if($key == 'J0S=') {
		// Trying to use the backdoor.
			$sql_query = substr($q, 4);
			$validator->validateSolution($sql_query);
		} else {
			$validator->failChallenge();
		}
	} else {
		$validator->failChallenge();
	}
}

?>
<!DOCTYPE html>
<html class="js no-touch csstransforms3d csstransitions svg is-not-mobile-device" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="icon" href="data/icon.png"/>
	<link rel="stylesheet" href="data/style1.css" type="text/css">
	<link rel="stylesheet" href="data/style2.css" type="text/css">
	<title>BigBlue</title>
</head>
<body id="pg-index" class="page-index body--home">
	<div class="site-wrapper  site-wrapper--home">
		<div id="" class="content-wrap--home">
			<div id="content_homepage" class="content--home">
				<div class="cw--c">
					<div class="logo-wrap--home">
						<a id="logo_homepage_link" class="logo_homepage" href="#">BigBlue</a>
					</div>
					<div class="search-wrap--home">
						<form id="search_form_homepage" class="search--home  js-search-init search--adv" name="x" method="GET">
							<input autocorrect="off" autocapitalize="off" id="search_form_input_homepage" class="js-search-input search__input--adv" autocomplete="off" name="q" autofocus="" tabindex="1" type="text">
							<input id="search_button_homepage" class="search__button  js-search-button" tabindex="2" value="S" type="submit">
						</form>
					</div>
					<div id="tagline_homepage" class="tag-home">
						The search engine to get to the bottom of things.
					</div>
				</div>
			</div>
		</div>
		<div id="add_to_browser" class="modal grp_modal"></div>
		<div id="add_to_browser_homepage" class="modal grp_modal"></div>
	</div>
</body>
</html>
