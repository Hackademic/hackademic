<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

$solution = '1'; // Number of results returned by the database.
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

$errorMessage = '';
if(isset($_POST['username']) && isset($_POST['password'])) {
	// We don't validate the answer from the student directly.
	// We first run it through an SQL database to see if the injection works.
	// Then we validate the number of results returned.
	$nbResults = testSQLQuery($_POST['username'], $_POST['password']);
	$valid = $validator->validateSolution($nbResults);
	if(!$valid) {
		switch($nbResults) {
			case -1:
				$errorMessage = 'SQL exception: incorrect syntax.';
				break;
			case 0:
				$errorMessage = 'Incorrect username or password.';
				break;
			default:
				$errorMessage = 'An error occurred, more than one user were found with this username and password. Please contact the administrator.';
				break;
		}
	}
}

/**
 * Tests the SQL injection.
 * @param username The username entered by the user.
 * @param password The password entered by the user.
 * @return The number of results returned by the SQL query.
 */
function testSQLQuery($username, $password) {
	$db = new PDO('sqlite:test.sqlite');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try {
		$results = $db->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
	} catch(Exception $e) {
		return -1;
	}
	return count($results->fetchAll());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="icon" href="data/icon.png"/>
	<meta charset="utf-8">
	<title>Log in AlienBoard</title>
	<link rel="stylesheet" href="data/style1.css" type="text/css">
	<link rel="stylesheet" href="data/style2.css" type="text/css">
	<link rel="stylesheet" href="data/style3.css" type="text/css">
	<link rel="stylesheet" href="data/style4.css" type="text/css">
</head>
<body>
	<div id="resbody">
		<nav class="">
			<div class="blacktopmenu">
				<ul>
					<a id="mainHome" href="#">
						<li style="padding: 0px 5px 0px 5px; height: 45px; width: 120px">
							<img src="data/alien.png" border="0" height="45px" width="37px">
							<img src="data/alien.png" border="0" height="45px" width="36px">
							<img src="data/alien.png" border="0" height="45px" width="37px">
						</li>
					</a>
					<a id="mainVideo" href="#">
						<li>video</li>
					</a>
					<a id="mainTop" href="#">
						<li>top</li>
					</a>
					<a id="mainHot" class="rsbold" href="#">
						<li>new</li>
					</a>
					<a id="mainNew" href="#">
						<li>live</li>
					</a>
					<a id="mainArchive" href="#">
						<li>archive</li>
					</a>
					<a id="mainRecent" href="#">
						<li>recent</li>
					</a>
					<a id="mainForums" href="#">
						<li>forums</li>
					</a>
					<a id="mainMyats" href="#">
						<li>join</li>
					</a>
					<a id="mainLogout" href="#">
						<li id="mainLogout">login</li>
					</a>
				</ul>
			</div>	
			<div class="submenu">
				<ul>
					<a id="subTop" href="#">
						<li>
							<i class="icon-fixed-width icon-flag icon-large"></i>top
						</li>
					</a>
					<a id="subHot" href="#">
						<li>
							<i class="icon-fixed-width icon-fire icon-large"></i>hot
						</li>
					</a>
					<a id="subNew" href="#">
						<li>
							<i class="icon-fixed-width icon-leaf icon-large"></i>new
						</li>
					</a>
					<a id="subArchive" href="#">
						<li>
							<i class="icon-fixed-width icon-calendar icon-large"></i>archive
						</li>
					</a>
					<a id="subPM" href="#">
						<li>
							<i class="icon-fixed-width icon-envelope icon-large"></i>messages
						</li>
					</a>
					<a id="subAccount" href="#">
						<li>
							<i class="icon-fixed-width icon-cog icon-large"></i>account
						</li>
					</a>
					<a id="subMembers" href="#">
						<li>
							<i class="icon-fixed-width icon-group icon-large"></i>members
						</li>
					</a>
					<a id="subProfile" href="#">
						<li>
							<i class="icon-fixed-width icon-dashboard icon-large"></i>profile
						</li>
					</a>
					<a id="subSub" href="#">
						<li>
							<i class="icon-fixed-width icon-bookmark icon-large"></i>subscriptions
						</li>
					</a>
					<a id="subComplain" href="#">
						<li>
							<i class="icon-fixed-width icon-frown icon-large"></i>complain
						</li>
					</a>
					<a id="subUpload" href="#">
						<li>
							<i class="icon-fixed-width icon-cloud-upload icon-large"></i>upload
						</li>
					</a>
					<a id="subChat" href="#">
						<li>
							<i class="icon-fixed-width icon-comments icon-large"></i>chat
						</li>
					</a>
					<a id="subChat" href="#">
						<li>
							<i class="icon-fixed-width icon-beer icon-large"></i>live
						</li>
					</a>
					<a id="subChat" href="#">
						<li>
							<i class="icon-fixed-width icon-fire-extinguisher icon-large"></i>hose
						</li>
					</a>
					<a id="mainLogout" href="#">
						<li id="subLogout">
							<i class="icon-fixed-width icon-signin icon-large"></i>login
						</li>
					</a>
				</ul>
			</div>
		</nav>
		<div id="goTop" class="tabBtn hide">
			<span class=" tabOff" title="scroll to top">
				<i class="icon-fixed-width icon-arrow-up icon-2x"></i>
			</span>
		</div>
		<div class="login" align="center">
			<?php
				if($errorMessage != '') {
					echo '<b style="color: #990000;">'.$errorMessage.'</b>';
				}
			?>
			<form name="loginForm" method="post">
				<span class="rsinfo4">username: </span>
				<input class="textform smaller" name="username" size="20" type="text">
				<span class="rsinfo4">password: </span>
				<input class="textform smaller" name="password" size="20" value="" type="password">
				<input name="submit" value="log in" type="submit">
			</form>
		</div>
		<div id="boardLeft">
			<div class="colad" style="padding: 0px; margin: 10px 10px 10px 0px; background: none;"></div>
			<div class="rsinfo3">board stats</div>
			<p class="rsinfo6">
				Total Posts: 8,082,022<br>
				Total Topics:  109,918<br>
				Total Members:  9,977<br>
				5,018 new posts in the past 24 hours<br>
				124,543 new posts in the past 30 days<br>
				140 new topics in the past 24 hours<br>
				2,911 new topics in the past 30 days<br>
				1,443 guests visiting right now.<br>
				167 members logged in right now<br>
				3,167 members visited in the past 24 hours<br>
				960 members posted in the past 24 hours<br><br>
				Most logged-in members at one time:<br>
				&nbsp;&nbsp;&nbsp;&nbsp;196 on Aug 23 2013 @ 19:45 GMT.<br>
				Most registed members in one day:<br>
				&nbsp;&nbsp;&nbsp;&nbsp;798 on Aug 24 2011 @ 08:30 GMT<br>
				Most new posts in one day:<br>
				&nbsp;&nbsp;&nbsp;&nbsp;3,258 on Apr 20 2012 @ 04:15 GMT.<br><br>
			</p>
			<div class="colad" style="padding: 0px; margin: 10px 10px 10px 0px; background: none;"></div>
			<div class="colad" style="padding: 0px; margin: 10px 10px 10px 0px; background: none;"></div>
		</div>
		<div id="boardRight">
			<div class="item">
				<div class="colT rsinfo2">Forums</div>
			</div>
			<div class="col2 board forums">
				<div class="colorC Ccons">
					<div class="i-178 homeicon"></div>
				</div>
				<a class="H3 warmgray">Off The Grid</a><br>
				<span class="rsinfo8"><b>41</b> topics<br>last post 86 min ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Ccons">
					<div class="i-19 homeicon"></div>
				</div>
				<a class="H3 warmgray">Aliens and UFOs</a><br>
				<span class="rsinfo8"><b>41,385</b> topics<br>last post 37 min ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Ccons">
					<div class="i-118 homeicon"></div>
				</div>
				<a class="H3 warmgray">9/11 Conspiracies</a><br>
				<span class="rsinfo8"><b>9,073</b> topics<br>last post 92 min ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Ccons">
					<div class="i-115 homeicon"></div>
				</div>
				<a class="H3 warmgray">The Gray Area</a><br>
				<span class="rsinfo8"><b>5,985</b> topics<br>last post 2 hrs ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Ccons">
					<div class="i-24 homeicon"></div>
				</div>
				<a class="H3 warmgray">Area 51 and other Facilities</a><br>
				<span class="rsinfo8"><b>3,463</b> topics<br>last post 2 days ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Ccur">
					<div class="i-109 homeicon"></div>
				</div>
				<a class="H3 warmgray">Global Meltdown</a><br>
				<span class="rsinfo8"><b>9,604</b> topics<br>last post 14 hrs ago</span>
			</div>

			<div class="col2 board forums">
				<div class="colorC Ccur">
					<div class="i-17 homeicon"></div>
				</div>
				<a class="H3 warmgray">Political Conspiracies</a><br>
				<span class="rsinfo8"><b>7,735</b> topics<br>last post 2 days ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Ccur">
					<div class="i-121 homeicon"></div>
				</div>
				<a class="H3 warmgray">Diseases and Pandemics</a><br>
				<span class="rsinfo8"><b>3,569</b> topics<br>last post 10 min ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Ccur">
					<div class="i-140 homeicon"></div>
				</div>
				<a class="H3 warmgray">Survival</a><br>
				<span class="rsinfo8"><b>5,209</b> topics<br>last post 15 min ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Ccur">
					<div class="i-120 homeicon"></div>
				</div>
				<a class="H3 warmgray">Disaster Conspiracies</a><br>
				<span class="rsinfo8"><b>1,067</b> topics<br>last post 1 days ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Cmys">
					<div class="i-25 homeicon"></div>
				</div>
				<a class="H3 warmgray">Conspiracies in Religions</a><br>
				<span class="rsinfo8"><b>7,086</b> topics<br>last post 78 min ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Cmys">
					<div class="i-32 homeicon"></div>
				</div>
				<a class="H3 warmgray">Ancient &amp; Lost Civilizations</a><br>
				<span class="rsinfo8"><b>5,742</b> topics<br>last post 3 hrs ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Cmys">
					<div class="i-149 homeicon"></div>
				</div>
				<a class="H3 warmgray">2012</a><br>
				<span class="rsinfo8"><b>3,353</b> topics<br>last post 3 days ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Cmys">
					<div class="i-116 homeicon"></div>
				</div>
				<a class="H3 warmgray">Origins and Creationism</a><br>
				<span class="rsinfo8"><b>2,341</b> topics<br>last post 4 min ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Cmys">
					<div class="i-27 homeicon"></div>
				</div>
				<a class="H3 warmgray">Paranormal Studies</a><br>
				<span class="rsinfo8"><b>13,193</b> topics<br>last post 4 hrs ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Cmys">
					<div class="i-37 homeicon"></div>
				</div>
				<a class="H3 warmgray">Predictions &amp; Prophecies</a><br>
				<span class="rsinfo8"><b>4,371</b> topics<br>last post 45 min ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Cmys">
					<div class="i-34 homeicon"></div>
				</div>
				<a class="H3 warmgray">Cryptozoology</a><br>
				<span class="rsinfo8"><b>4,208</b> topics<br>last post 6 hrs ago</span>
			</div>
			<div class="col2 board forums">
				<div class="colorC Ccur">
					<div class="i-33 homeicon"></div>
				</div>
				<a class="H3 warmgray">Other Current Events</a><br>
				<span class="rsinfo8"><b>27,429</b> topics<br>last post 28 min ago</span>
			</div>
		</div>
		<br clear="all"><br><br>
	</div>
</body>
</html>
