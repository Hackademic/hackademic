<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = '1104black110'; // Birthday + dog's name + ZIP code.
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

$error = false;
if(isset($_POST['email']) && isset($_POST['pass'])) {
	if($_POST['email'] == 'abby.sciuto@cafebook.com') {
		$answer = $_POST['pass'];
		$error = !$validator->validateSolution($answer);
	} else {
		$validator->failChallenge();
		$error = true;
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<link rel="icon" href="data/cafe.png"/>
	<title id="pageTitle">Cafébook</title>
	<link type="text/css" rel="stylesheet" href="data/style1.css">
	<link type="text/css" rel="stylesheet" href="data/style2.css">
	<link type="text/css" rel="stylesheet" href="data/style3.css">
	<link type="text/css" rel="stylesheet" href="data/style4.css">
</head>
<body class="login_page cbx UIPage_LoggedOut _2gsg gecko win" dir="ltr">
	<div class="_li">
		<div id="pagelet_bluebar">
			<div id="blueBarHolder" class="_2gsf">
				<div id="blueBar" class="aboveSidebar">
					<div>
						<div class="loggedout_menubar_container">
							<div class="clearfix loggedout_menubar">
								<a class="lfloat _ohe" href="#">
									<i class="cb_logo img sp_9vUokIDmpP8 sx_15c231">
										<u>Cafébook Logo</u>
									</i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="globalContainer" class="uiContextualLayerParent">
			<div id="content" class="cb_content clearfix">
				<div class="UIFullPage_Container">
					<div class="mvl ptm uiInterstitial login_page_interstitial uiInterstitialLarge uiBoxWhite">
						<div class="uiHeader uiHeaderBottomBorder mhl mts uiHeaderPage interstitialHeader">
							<div class="clearfix uiHeaderTop">
								<div class="rfloat _ohf">
									<div class="uiHeaderActions"></div>
								</div>
								<div>
									<h2 class="uiHeaderTitle">Cafébook login</h2>
								</div>
							</div>
						</div>
						<div class="phl ptm uiInterstitialContent">
							<div class="login_form_container">
								<form id="login_form" method="post">
									<?php
										if($error) {
									?>
										<div class="hidden_elem"></div>
										<div class="pam login_error_box uiBoxRed">
											<div class="fsl fwb fcb">Incorrect email address or password</div>
											<div>
												<p>
													You should have received your password by email.<br/>
													If you've lost it, you can request a new through <i>Unable to login</i>.
												</p>
											</div>
										</div>
									<?php
										}
									?>
									<div id="loginform">
										<div class="form_row clearfix">
											<label for="email" class="login_form_label">Email address:</label>
											<input class="inputtext" id="email" name="email" tabindex="1" type="text">
										</div>
										<div class="form_row clearfix">
											<label for="pass" class="login_form_label">Password:</label>
											<input name="pass" id="pass" class="inputpassword" tabindex="1" type="password">
										</div>
										<div class="persistent">
											<div class="uiInputLabel clearfix uiInputLabelLegacy">
												<input id="persist_box" value="1" name="persistent" class="uiInputLabelInput uiInputLabelCheckbox" type="checkbox">
												<label for="persist_box" class="uiInputLabelLabel">Keep the session alive</label>
											</div>
										</div>
										<div id="buttons" class="form_row clearfix">
											<label class="login_form_label"></label>
											<div id="login_button_inline">
												<label class="uiButton uiButtonConfirm uiButtonLarge" id="loginbutton" for="u_0_1">
													<input value="Sign in" name="login" tabindex="1" id="u_0_1" type="submit">
												</label>
											</div>
											<div id="register_link">or 
												<strong>
													<a href="#">Sign up on Cafébook</a>
												</strong>
											</div>
										</div>
										<p class="reset_password form_row">
											<a href="#">Unable to login?</a>
										</p>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="uiList ptm localeSelectorList _509- _4ki _6-h _6-j _6-i"></div>
				</div>
			</div>
			<div id="pageFooter">
				<div id="contentCurve"></div>
				<div role="contentinfo">
					<table class="uiGrid _51mz navigationGrid" cellpadding="0" cellspacing="0">
						<tbody>
							<tr class="_51mx">
								<td class="_51m- hLeft plm">
									<a href="#">Mobile</a>
								</td>
								<td class="_51m- hLeft plm">
									<a href="#">Find friends</a>
								</td>
								<td class="_51m- hLeft plm">
									<a href="#">People</a>
								</td>
								<td class="_51m- hLeft plm">
									<a href="#">Pages</a>
								</td>
								<td class="_51m- hLeft plm">
									<a href="#">Places</a>
								</td>
								<td class="_51m- hLeft plm">
									<a href="#">Applications</a>
								</td>
								<td class="_51m- hLeft plm">
									<a href="#">Games</a>
								</td>
								<td class="_51m- hLeft plm _51mw">
									<a href="#">Music</a>
								</td>
								<td class="_51m- hLeft plm">
									<a href="#">About</a>
								</td>
								<td class="_51m- hLeft plm">
									<a href="#">Create an ad</a>
								</td>
							</tr>
							<tr class="_51mx">
								<td class="_51m- hLeft plm">
									<a href="#">Create a page</a>
								</td>
								<td class="_51m- hLeft plm">
									<a href="#">Developers</a>
								</td>
								<td class="_51m- hLeft plm">
									<a href="#">Careers</a>
								</td>
								<td class="_51m- hLeft plm">
									<a href="#">Confidentiality</a>
								</td>
								<td class="_51m- hLeft plm _51mw">
									<a href="#">Cookies</a>
								</td>
								<td class="_51m- hLeft plm">
									<a href="#">Term of use</a>
								</td>
								<td class="_51m- hLeft plm">
									<a href="#">Help</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="mvl copyright">
					<div class="fsm fwn fcg">
						<span>© Cafébook 2014</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
