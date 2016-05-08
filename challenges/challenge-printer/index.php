<!DOCTYPE html>
<html>
<head>
	<title>Laser Printer 4800FT</title>
	<link rel="stylesheet" type="text/css" href="data/style.css">
	<script type="text/javascript">
		function admin() {
			alert('You need to be logged in as Admin to see this page.');
		}
	</script>
</head>
<body>
	<?php include('common.html'); ?>
	<section id="main">
		<nav id="subnavbar">
			<ul>
				<li><a href="#">Printer Status</a> |</li>
				<li><a href="#">Printer Events</a> |</li>
				<li><a href="#">Printer Volume</a> |</li>
				<li><a href="#">Printer Information</a></li>
			</ul>
		</nav>
		<h2>Printer Status - <span id="refresh">Refresh</span></h2>
		<div id="color-status">
			<img src="data/color-status.png">
		</div>
		<table id="consumables">
			<tr>
				<th width="250px">Consumables:</th>
				<th>Status:</th>
			</tr>
			<tr>
				<td>Imaging Drum</td>
				<td><div class="status-ok">OK</div></td>
			</tr>
			<tr>
				<td>Toner</td>
				<td><div class="status-ok">OK</div></td>
			</tr>
			<tr>
				<td>First Paper Tray</td>
				<td><div class="status-ok">OK</div></td>
			</tr>
			<tr>
				<td>Second Paper Tray</td>
				<td><div class="status-ok">OK</div></td>
			</tr>
			<tr>
				<td>Scanner</td>
				<td><div class="status-ok">OK</div></td>
			</tr>
			<tr>
				<td>Feed Roller</td>
				<td><div class="status-ok">OK</div></td>
			</tr>
			<tr>
				<td>Upper Fuser Pressure Roller</td>
				<td><div class="status-ok">OK</div></td>
			</tr>
			<tr>
				<td>Lower Fuser Pressure Roller</td>
				<td><div class="status-ok">OK</div></td>
			</tr>
		</table>
	</section>
</body>
</html>
