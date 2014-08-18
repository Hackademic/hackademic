<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = '#Adh@$2HLuA4'; // One of the passwords from passwords.txt
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

$error = false;
if(isset($_POST['username']) && isset($_POST['password'])) {
	if($_POST['username'] == 'Admin') {
		$answer = $_POST['password'];
		$error = !$validator->validateSolution($_POST['password']);
	} else {
		$validator->failChallenge();
		$error = true;
	}
}

?>
<!DOCTYPE html>
<html class="client-js ve-not-available" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<title>Log In - Politipedia</title>
	<link rel="stylesheet" href="data/style1.css">
	<link rel="stylesheet" href="data/style2.css">
	<link rel="stylesheet" href="data/style3.css">
	<link rel="shortcut icon" href="data/icon.png">
</head>
<body class="mediawiki ltr sitedir-ltr ns--1 ns-special mw-special-Userlogin skin-vector action-view vector-animateLayout">
	<div id="mw-page-base" class="noprint"></div>
	<div id="mw-head-base" class="noprint"></div>
	<div id="content" class="mw-body" role="main">
		<a id="top"></a>
		<h1 id="firstHeading" class="firstHeading">
			<span dir="auto">Log In</span>
		</h1>
		<div id="bodyContent" class="mw-body-content">
			<div id="jump-to-nav" class="mw-jump">
				Go to: <a href="#mw-navigation">navigation</a>, <a href="#p-search">search</a>
			</div>
			<div id="mw-content-text">
				<div class="mw-ui-container">
					<div id="userloginForm">
						<form name="userlogin" class="mw-ui-vform" method="post">
							<section class="mw-form-header"></section>
							<?php
								if($error) {
									echo '<div class="errorbox">';
									echo "\t<strong>Login error</strong>";
									echo "\t<br>Incorrect username or password entered. Please try again.";
									echo '</div>';
								}
							?>
							<div class="mw-ui-vform-field">
								<label for="wpName1">Username</label>
								<input class="loginText" id="wpName1" tabindex="1" size="20" autofocus="" placeholder="Enter your username" name="username">
							</div>
							<div class="mw-ui-vform-field">
								<label for="wpPassword1">
									Password <a href="#" class="mw-ui-flush-right">Forgot your password?</a>
								</label>
								<input class="loginPassword" id="wpPassword1" tabindex="2" size="20" placeholder="Enter your password" name="password" type="password">
							</div>
							<div class="mw-ui-vform-field">
								<label class="mw-ui-checkbox-label">
									<input name="remember" value="1" id="wpRemember" tabindex="4" type="checkbox">
									Keep me logged in
								</label>
							</div>
							<div class="mw-ui-vform-field">
								<input id="wpLoginAttempt" tabindex="6" class="mw-ui-button mw-ui-big mw-ui-block mw-ui-constructive" value="Log in" name="wpLoginAttempt" type="submit">
							</div>
							<div class="mw-ui-vform-field" id="mw-userlogin-help">
								<a href="#">Help with logging in</a>
							</div>
							<div id="mw-createaccount-cta">
								Don't have an account?<a href="#" id="mw-createaccount-join" tabindex="7" class="mw-ui-button mw-ui-progressive">Join Politipedia</a>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="visualClear"></div>
		</div>
	</div>
	<div id="mw-navigation">
		<h2>Navigation menu</h2>
		<div id="mw-head">
			<div id="p-personal" role="navigation" class="">
				<ul>
					<li id="pt-createaccount">
						<a href="#">Create an account</a>
					</li>
					<li id="pt-login" class="active">
						<a href="#">Log in</a>
					</li>
				</ul>
			</div>
			<div id="left-navigation"></div>
			<div id="right-navigation">
				<div id="p-search" role="search">
					<form id="searchform">
						<div id="simpleSearch">
							<input autocomplete="off" tabindex="8" name="search" placeholder="Search" id="searchInput" type="search">
							<input name="go" id="searchButton" class="searchButton" type="submit">
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="mw-panel">
			<div id="p-logo" role="banner">
				<a style="background-image: url(data/logo.png);" href="#"></a>
			</div>
			<div class="portal first" role="navigation" id="p-navigation">
				<div class="body">
					<ul>
						<li id="n-mainpage-description">
							<a href="#">Home</a>
						</li>
						<li id="n-randompage">
							<a href="#">Random page</a>
						</li>
						<li id="n-contact">
							<a href="#">Contact</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="portal" role="navigation" id="p-Contribuer">
				<h3 id="p-Contribuer-label">Contribute</h3>
				<div class="body">
					<ul>
						<li id="n-aboutwp">
							<a href="#">Start with Politipedia</a>
						</li>
						<li id="n-help">
							<a href="#">Help</a>
						</li>
						<li id="n-portal">
							<a href="#">Community</a>
						</li>
						<li id="n-recentchanges">
							<a href="#">Recent modifications</a>
						</li>
						<li id="n-sitesupport">
							<a href="#">Make a donation</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="portal" role="navigation" id="p-tb">
				<h3 id="p-tb-label">Tools</h3>
				<div class="body">
					<ul>
						<li id="t-upload">
							<a href="#">Import a file</a>
						</li>
						<li id="t-specialpages">
							<a href="#">Special pages</a>
						</li>
						<li id="t-print">
							<a href="#" rel="alternate">Printable version</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div id="footer" role="contentinfo">
		<ul id="footer-places">
			<li id="footer-places-privacy">
				<a href="#">Confidentiality policies</a>
			</li>
			<li id="footer-places-about">
				<a href="#">About Politipedia</a>
			</li>
			<li id="footer-places-developers">
				<a href="#">Developers</a>
			</li>
			<li id="footer-places-mobileview">
				<a href="#" class="noprint stopMobileRedirectToggle">Mobile website</a>
			</li>
		</ul>
		<div style="clear:both"></div>
	</div>
	<div class="row">
		<div class="uls-language-settings-close-block eight columns offset-by-four">
			<span id="languagesettings-close" class="uls-icon-close"></span>
		</div>
	</div>
	<div class="row" id="languagesettings-panels">
		<div class="four columns languagesettings-menu">
			<h1></h1>
			<div class="settings-menu-items"></div>
		</div>
		<div id="languagesettings-settings-panel" class="eight columns"></div>
		<div class="row"></div>
		<div class="row language-settings-buttons">
		</div>
	</div>
	</div>
</body>
</html>
