<?php

$message = '';
if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['confirmation'])) {
	if($_POST['password'] == $_POST['confirmation']) {
		if(is_numeric($_POST['password']) && strlen($_POST['password']) == 3) {
			$message = 'Your demand has been registered.<br/>Your account still need to be enabled by an administrator.';
		} else {
			$message = 'The password must be composed of three digits.';
		}
	} else {
		$message = 'The confirmation password doesn\'t correspond to the actual one.';
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
								<li id="rubric1" class="left_rub_selected" style="z-index:2;" onclick="goToPage('index.php');">Home</li>
								<li id="rubric2" class="right_rub" style="left:120px; z-index:1;">Sign in</li>
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
			<form name="formu" method="POST">
				<table class="main">
					<tr>
						<td class="main" style="padding-left: 40px">
							<table class="headarray">
								<tr>
									<td class="left">
										<img src="data/corner.png" class="corner" height="17" width="45">
									</td>
									<td class="right">Request a new account</td>
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
									<td class="left"></td>
									<td class="content">
										<?php
											echo '<p style="color:#F00;font-weight:700;">'.$message.'</p>';
										?>
										<table class="info_accueil">
											<tr>
												<td class="info_label">Login:</td>
											</tr>
											<tr>
												<td class="info_field">
													<input name="login" value="" class="login" type="text">
												</td>
											</tr>
											<tr>
												<td class="info_label">Password:</td>
											</tr>
											<tr>
												<td class="info_field">
													<input name="password" class="password" type="password">
												</td>
											</tr>
											<tr>
												<td class="info_label">Confirmation:</td>
											</tr>
											<tr>
												<td class="info_field">
													<input name="confirmation" class="password" type="password">
												</td>
											</tr>
											<tr>
												<td class="info_field">
													<input name="submit" type="submit" value="Submit">
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
