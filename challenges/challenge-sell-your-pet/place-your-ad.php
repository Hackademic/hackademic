<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="iso-8859-15">
	<link rel="icon" href="data/logo.png"/>
	<link href="data/jquery-ui.min.css" rel="stylesheet" type="text/css">
	<link href="data/style2.css" rel="stylesheet" type="text/css">
	<title>Sell your pet!</title>
	<script type="text/javascript" src="data/jquery.min.js"></script>
	<script type="text/javascript" src="data/jquery-ui.min.js"></script>
	<script type="text/javascript">
		$(function() {
			// jQuery UI tooltips for the input's titles.
			$('#formular input, #formula textarea').tooltip();
		});
	</script>
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
				<div class="content-border">
					<div class="content-color">
						<div class="maintext">
							<div>
								<p>
									<b class="upper">Placing an ad on <i>Sell you pet!</i> is FREE.</b> <br>
									Your ad will be online for 60 days. <br>
									During this period, you will be able to remove your ad at any time. <br>
									<a href="#">See the diffusion rules</a>
								</p>
							</div>
						</div>
						<form method="post" action="submit-an-ad.php" name="formular" enctype="multipart/form-data" id="formular">
							<div id="newad_form" class="lbcAcont">
								<input name="check_type_diff" id="check_type_diff" value="0" type="hidden">
								<div class="clear"></div>
								<h2>Localization</h2>
								<div class="subtitle_triangle">&nbsp;</div>
								<div class="clear"></div>
								<div class="labelform" style="display:block;" id="ldpt_code">
									<label>Country:</label>
								</div>
								<div class="adinput height-limit" id="ddpt_code" style="display:block;">
									<div class="select">
										<select name="country" id="dpt_code">
											<option selected="selected" value="">«Choose the country»</option>
											<option value="193">Canada</option>
											<option value="3">France</option>
											<option value="191">Germany</option>
											<option value="178">Great Britain</option>
											<option value="177">Greece</option>
											<option value="194">Ireland</option>
											<option value="192">Italy</option>
											<option value="195">Netherlands</option>
											<option value="175">Spain</option>
											<option value="2">USA</option>
										</select>
									</div>
								</div>
								<div class="clear"></div>
								<div class="labelform">
									<label>City:</label>
								</div>
								<div class="adinput">
									<input title="/^[\w\s-\.]+$/" name="city" size="6" type="text">
								</div>
								<div class="clear"></div>
								<div class="labelform">
									<label>Postal address:</label>
								</div>
								<div class="adinput">
									<input name="postal_address" title="/^[\w\s-\.]+$/" size="6" type="text">
									<div class="clear"></div>
								</div>
								<div class="clear"></div>
								<h2>Category</h2>
								<div class="subtitle_triangle">&nbsp;</div>
								<div class="clear"></div>
								<div class="labelform">
									<label>Category:</label>
								</div>
								<div class="adinput">
									<div class="select">
										<select name="category" id="category">
											<option selected="selected" value="">«Choose the category»</option>
											<option value="1">Cat</option>
											<option value="2">Dog</option>
											<option value="8">Fish</option>
											<option value="4">Horse</option>
											<option value="5">Guinea pig</option>
											<option value="6">Mouse</option>
											<option value="7">Parrot</option>
											<option value="3">Snake</option>
										</select>
									</div>
								</div>
								<div class="clear"></div>
								<div class="clear"></div>
								<div class="labelform"> You are:</div>
								<div class="adinput">
									<div style="display: inline;" id="dprivate_ad" class="radio">
										<input style="display: inline;" id="private_ad_id" name="professional" value="no" checked="checked" type="radio">
										<label style="display: inline;" for="private_ad_id" id="lprivate_ad">An individual</label>&nbsp;
									</div>
									<div style="display: inline;" id="dcompany_ad" class="radio">
										<input style="display: inline;" id="company_ad_id" name="professional" value="yes" type="radio">
										<label style="display: inline;" for="company_ad_id" id="lcompany_ad">A professional</label>
									</div>
									<div class="clear"></div>
								</div>
								<div class="clear"></div>
								<div id="comptepro_disable_fields">
									<div class="adinput"></div>
									<div class="clear"></div>
									<div id="store_holder"></div>
									<div class="clear"></div>
									<h2>Your information</h2>
									<div class="subtitle_triangle">&nbsp;</div>
									<div class="clear"></div>
									<div class="labelform" id="lname">Your name:</div>
									<div class="adinput">
										<input name="name" title="/^[\w\s-]+$/" size="35" type="text">
									</div>
									<div class="clear"></div>
									<div class="clear"></div>
									<div class="labelform">
										<label for="email">Mail address:</label>
									</div>
									<div class="adinput">
										<input name="email" title="/^[\w\.-]+@[\w\.-]+\.[\w]{1,5}$/" size="35" type="text">
									</div> 
									<br>
									<div class="labelform">
									<label>Phone number:</label>
									</div>
									<div class="adinput">
									<input name="phone" title="/^\d+$/" size="17" type="text">
									</div>
									<div class="clear"></div>
									<h2>Your ad</h2>
									<div class="subtitle_triangle">&nbsp;</div>
									<div class="clear"></div>
									<div class="labelform" id="lsubject">
										<label>Title of the ad:</label>
									</div>
									<div class="adinput">
										<input name="title" title="/^[\w\s-_\.]+$/" size="50" type="text">
									</div>
									<div class="clear"></div>
									<div class="clear"></div>
									<br>
									<br>
									<br>
									<div class="clear"></div>
									<div class="clear"></div>
									<div class="clear"></div>
									<div class="clear"></div>
									<div class="AdInput400 price_min_max_message"></div>
									<div class="clear"></div>
									<div class="clear"></div>
									<div class="clear"></div>
									<div class="clear"></div>
									<div class="clear"></div>
									<div class="clear"></div>
									<div class="labelform" style="clear:left;" id="lbody">
										<label>Text of the ad:</label>
									</div>
									<div class="adinput">
										<textarea cols="50" title="/^[\w\s-_\.]+$/" rows="10" name="ad_text" id="body"></textarea>
									</div>
									<div class="clear"></div>
									<div id="price_box" style="display: inline;">
										<div class="labelform" id="lprice" style="display: block;">Price:</div>
										<div class="adinput" id="dprice" style="display: block;">
											<span class="unit">$</span>
											<input name="price" title="/\d+/" size="10" id="price" type="text">
											<div class="clear"></div>
										</div>
									</div>
									<div class="clear"></div>
									<a name="photo_principale_anchor"></a>
									<div class="clear"></div>
									<div id="photosup_layout_part_crlf_target">
										<div class="clear" id="photosup_layout_crlf"></div>
									</div>
									<div class="clear"></div>
									<a name="photosup_anchor"></a>
									<div class="labelform">&nbsp;</div>
									<div class="adinput" id="submit-buttoms">
										<input name="validate" value="Submit" class="button" type="submit">
									</div>
									<div class="clear"></div>
								</div> 
							</div>
						</form>
						<div class="clear"></div>
					</div>
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
