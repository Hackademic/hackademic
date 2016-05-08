<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = 128;
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

$error = false;
if(isset($_POST['authlogin']) && isset($_POST['authpasswd'])) {
	if($_POST['authlogin'] == 'admin') {
		$answer = $_POST['authpasswd'];
		$error = !$validator->validateSolution($answer);
	} else {
		$validator->failChallenge();
		$error = true;
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Router</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="data/fonts.css">
	<link rel="stylesheet" type="text/css" href="data/page.css">
	<link rel="stylesheet" type="text/css" href="data/menu.css">
	<link rel="stylesheet" type="text/css" href="data/header.css">
	<link rel="stylesheet" type="text/css" href="data/contener.css">
	<link rel="stylesheet" type="text/css" href="data/lbpopup.css">
	<link rel="stylesheet" type="text/css" href="data/styles.css">
	<link rel="icon" href="data/logo.png">
	<script type="text/javascript" src="data/scripts.js"></script>
</head>
<body>
	<div id="GUI_master">
		<div class="main">
			<table class="main">
				<tr>
					<td class="header">
						<div id="header">
							<h4>Router</h4>
							<ul id="rubrics">
								<li id="rubric1" class="left_rub_selected" style="z-index:2;">Home</li>
								<li id="rubric2" class="right_rub" style="left:120px; z-index:1;" onclick="goToPage('signin.php');">Sign in</li>
							</ul>
						</div>
					</td>
					<td class="header" style="width: 70px">
						<span class="help">Help</span>
						<a href="#">
							<img src="data/help.png" height="31" width="31">
						</a>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="authempty"></td>
				</tr>
			</table>
			<form name="formu" method="POST" action="index.php">
				<table class="main">
					<tr>
						<td class="main" style="padding-left: 40px">
							<table class="headarray">
								<tr>
									<td class="left">
										<img src="data/corner.png" class="corner" height="17" width="45">
									</td>
									<td class="right">Statut</td>
								</tr>
							</table>
						</td>
						<td class="main"></td>
					</tr>
					<tr>
						<td class="main">
							<div id="contener" style="margin-top: 0px">
								<table class="contener">
									<tr>
										<td class="topleft"></td>
										<td class="top">
											<img src="data/top.png" height="8">
										</td>
										<td class="topright"></td>
									</tr>
								</table>
								<table class="contener">
									<tr>
									<td class="left">
									</td>
									<td class="content">
										<table class="home">
											<tr>
												<td class="icone">
													<img src="data/services.png" height="30" width="35">
												</td>
												<td class="titlerubric" colspan="2">1.Services</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">1.1</td>
															<td class="libelle" style="width:180px;">Internet Connection:</td>
															<td class="statusenable">Enabled</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">1.2</td>
															<td class="libelle" style="width:180px;">IP telephony:</td>
															<td class="statusenable">Enabled</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">1.3</td>
															<td class="libelle" style="width:180px;">Digital TV:</td>
															<td class="statusenable">Enabled</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
												<table class="homeinfo">
													<tr>
														<td class="id">1.4</td>
														<td class="libelle" style="width:180px;">Hotspot WiFi:</td>
														<td class="statusdisable">Disabled</td>
													</tr>
												</table>
												</td>
											</tr>
										</table>
										<table class="separator">
											<tr>
												<td class="separator"></td>
											</tr>
										</table>
										<table class="home">
											<tr>
												<td class="icone">
													<img src="data/wifi.png" height="20" width="30">
												</td>
												<td class="titlerubric" colspan="2">2.WiFi</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">2.1</td>
															<td class="libelle" style="width:180px;">WiFi:</td>
															<td class="statusenable">Enabled</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">2.2</td>
															<td class="libelle">Network name (SSID):</td>
															<td class="value">HOME1234</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">2.3</td>
															<td class="libelle">Mode:</td>
															<td class="value">802.11 b/g/n</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">2.4</td>
															<td class="libelle">Channel number:</td>
															<td class="value">11</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">2.5</td>
															<td class="libelle">Security mode:</td>
															<td class="value">WPA/WPA2 Auto tkip_aes</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
										<table class="separator">
												<tr>
													<td class="separator"></td>
												</tr>
										</table>
										<table class="home">
											<tr>
												<td class="icone">
													<img src="data/general.png" height="28" width="28">
												</td>
												<td class="titlerubric" colspan="2">3.General</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">3.1</td>
															<td class="libelle">Router name:</td>
															<td class="value">Home1234</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">3.2</td>
															<td class="libelle">Software version:</td>
															<td class="value">RV2_610A</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">3.3</td>
															<td class="libelle">IP address WAN:</td>
															<td class="value">109.219.24.229</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">3.4</td>
															<td class="libelle">VoIP phone number:</td>
															<td class="value">XXX XXXXXXXXX</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">3.5</td>
															<td class="libelle">Time since last reboot:</td>
															<td class="value">7 days 00:46:50</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">3.6</td>
															<td class="libelle">Red Ethernet port:</td>
															<td class="value">Internet, TV</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">3.7</td>
															<td class="libelle">Yellow Ethernet port:</td>
															<td class="value">Internet, TV</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">3.8</td>
															<td class="libelle">Green Ethernet port:</td>
															<td class="value">Internet, TV</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">3.9</td>
															<td class="libelle">White Ethernet port:</td>
															<td class="value">Internet, TV</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">3.10</td>
															<td class="libelle" style="width:130px;">DynDNS:</td>
															<td class="statusdisable">Disabled</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">3.11</td>
															<td class="libelle" style="width:130px;">DHCP Server:</td>
															<td class="statusenable">Enabled</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td style="background-color: rgb(255, 255, 255);" class="homeinfo">
													<table class="homeinfo">
														<tr>
															<td class="id">3.12</td>
															<td class="libelle" style="width:130px;">UPnP:</td>
															<td class="statusdisable">Disabled</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
										<table class="separator">
											<tr>
												<td class="separator"></td>
											</tr>
										</table>
										<table class="home">
											<tr>
												<td class="icone">
													<img src="data/devices.png" height="22" width="30">
												</td>
												<td class="titlerubric" colspan="2">4.Connected devices</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td class="homeinfo">
													<table class="deviceinfo">
														<tr>
															<td class="libelle">computer-john (xx:xx:xx:xx:ad:cd)</td>
															<td class="address">DHCP:192.168.1.10</td>
															<td class="type">
																<img src="data/typeethernet.png" height="17" width="26">
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td class="homeinfo">
													<table class="deviceinfo">
														<tr>
															<td class="libelle">computer-jack (xx:xx:xx:xx:f0:27)</td>
															<td class="address">192.168.1.15</td>
															<td class="type">
																<img src="data/typeethernet.png" height="17" width="26">
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td class="space">&nbsp;</td>
												<td class="homeinfo">
													<table class="deviceinfo">
														<tr>
															<td class="libelle">mac-alice (xx:xx:xx:xx:85:4e)</td>
															<td class="address">DHCP:192.168.1.14</td>
															<td class="type">
																<img src="data/typeethernet.png" height="17" width="26">
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
									<td class="right"></td>
								</tr>
							</table>
							<table class="contener">
								<tr>
									<td class="bottomleft"></td>
									<td class="bottom">
										<img src="data/vide.htm" height="1" width="1">
									</td>
									<td class="bottomright"></td>
								</tr>
							</table>
						</div>
					</td>
					<td class="main">
						<div id="menu" style="margin-top: 0px">
							<table>
								<tr>
									<td class="topleft"></td>
									<td class="top"></td>
									<td class="topright"></td>
								</tr>
								<tr>
									<td class="left"></td>
									<td>
										<div class="info_accueil">
											<table class="info_accueil">
												<tr>
												<td class="info_pref">
													<img src="data/preferencesbutton.png"> Authentication</td>
												</tr>
												<tr>
													<td class="info_label">Login:</td>
												</tr>
												<tr>
													<td class="info_field">
														<input name="authlogin" value="" class="login" title="The default value is admin" type="text">
													</td>
												</tr>
												<tr>
													<td class="info_label">Password:</td>
												</tr>
												<tr>
													<td class="info_field">
														<input name="authpasswd" value="" class="password" title="Enter your password here" type="password">
													</td>
												</tr>
												<?php
													if($error) {
														echo '<tr>';
														echo '<td class="info_statusnok">Failure to authenticate.</td>';
														echo '</tr>';
													}
												?>
											</table>
										</div>
									</td>
									<td class="right"></td>
								</tr>
								<tr>
									<td class="sepleftbig"></td>
									<td class="sepactbig">
										Access <a href="#" onclick="document.forms['formu'].submit()" title="Click here to submit">
											<img src="data/nextbutton.png">
										</a>
									</td>
									<td class="right"></td>
								</tr>
								<tr>
									<td class="bottomleft"></td>
									<td class="bottom">
										<img src="data/vide.htm" height="1" width="1">
									</td>
									<td class="bottomright"></td>
								</tr>
							</table>
						</div>
					</td>
					</tr>
				</table>
			</form>
			<table>
				<tr>
					<td height="25"></td>
				</tr>
				<tr>
					<td>
						<div style="width: 770px; height: 1px; background-color: rgb(202, 202, 202); font-size: 0pt;"></div>
					</td>
				</tr>
				<tr>
					<td>
						<span style="cursor: pointer; font-weight: bold; color: rgb(148, 148, 148); font-size: 12px; position: absolute; left: 682px;">Legal notice</span>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>
