<?php
		/* Necessary includes and session starting */
		//include_once dirname(__FILE__).'/../../init.php';		
        session_start();
		/* Reset the session if the one hour time limit has passed */
		if (isset($_SESSION['init_timer'])) {
			if (time()-$_SESSION['init_timer']>3600) {
				unset($_SESSION['init_timer']);
				unsetSession();
				header("Location: index.php?error=10");
				die();
			}
		} else {
			$_SESSION['init_timer'] = time();
		}

        //require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
		
		/* $_GET['user'] is set only when user comes through the hackademic page (where user clicks on 'try it' button) */
		//if (isset($_GET['user']) && !(isset($_SESSION['init_timer']))) {
		//	$monitor->update(CHALLENGE_INIT,$_GET['user'],$_GET['id'],$_GET['token']);
		/* If the user refreshed the page (keeping the GET vars), or came through the challenge page,
		   just reset the session */
		//} 
		if (isset($_GET['user']) && (isset($_SESSION['init_timer']))){
			unsetSession();
		}
		/* If he's not logged in to hackademic (session's not set), send him back to do so */
		if (!isset($_COOKIE['PHPSESSID'])) {
			header("Location: ../../index.php");
			die();
		}
		/* If our cookie's value (our username) is "admin" and at the same time, ch02 session variable hasn't got a value
		(flag that tells us that second challenge is complete), then give him the easter egg, for he changed the cookie's value
		and didn't inject anything into the database */
		if ( ($_COOKIE['izon']=="admin") && (!isset($_SESSION['ch02'])) ) {
			$_SESSION['ch02']=1;
			if (!isset($_SESSION['ch02_timer'])) { $_SESSION['ch02_timer']=time(); }
			$_SESSION['ch02_egg']=1;
			setcookie('izon','admin', time()+3600);
		}
		/* A function that transforms timestamps into a readable HH:MM:SS format */
		function returnTime($seconds) {
			$hours = floor($seconds / 3600);
			$mins = floor(($seconds - ($hours*3600)) / 60);
			$secs = floor($seconds % 60);
			return sprintf("%1$02d:%2$02d:%3$02d",$hours,$mins,$secs);
		}
		/* function that resets the session variables */
		function unsetSession() {
			unset($_SESSION['ch01']);
			unset($_SESSION['ch02']);
			unset($_SESSION['ch03']);
			unset($_SESSION['ch04']);
			unset($_SESSION['ch01_timer']);
			unset($_SESSION['ch02_timer']);
			unset($_SESSION['ch03_timer']);
			unset($_SESSION['ch04_timer']);
			unset($_SESSION['ch04_stamp']);
			unset($_SESSION['ch01_egg']);
			unset($_SESSION['ch02_egg']);
			unset($_SESSION['random_date']);
		}
		/* Random number to use in recent news*/
		if (!isset($_SESSION['random_date'])) {
			$_SESSION['random_date']=rand(12,48);
		}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Welcome to Izon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>
	body {
background: #b8c6df; /* Old browsers 
background: -moz-linear-gradient(-45deg,  #b7deed 0%, #71ceef 50%, #21b4e2 51%, #b7deed 100%); 
background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#b7deed), color-stop(50%,#71ceef), color-stop(51%,#21b4e2), color-stop(100%,#b7deed)); 
background: -webkit-linear-gradient(-45deg,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); 
background: -o-linear-gradient(-45deg,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); 
background: -ms-linear-gradient(-45deg,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); 
background: linear-gradient(135deg,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); 
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b7deed', endColorstr='#b7deed',GradientType=1 );  */
height: 100vh;

	}
	.dropcap  {
		float: left; color: #00005b; font-size: 75px; line-height: 60px; padding-top: 4px; padding-right: 8px; padding-left: 3px; font-family: Georgia; text-shadow: 2px 2px 4px black;
	}
    </style>
	<link rel="shortcut icon" href="img/favicon.ico" />
	<link rel="icon" href="img/favicon.ico" />
  </head>
  <body>
<div class="navbar navbar-inverse navbar-static-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="./index.html">Izon</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="">
                <a href=""><i class="icon-home icon-white"></i> Home</a>
              </li>
              <li class="">
                <?php
					/* Code for Info Popup (depending on the completed challenges)*/
					if (isset($_SESSION['ch03'])) {
						echo '<a href="#" class="" data-toggle="popover" data-placement="bottom" data-selector="true" data-content="" title="" id="info-ch04" rel="popover"><i class="icon-info-sign icon-white"></i> Info</a>';
					} else if (isset ($_SESSION['ch02']) && (!isset($_SESSION['ch03']))) {
						echo '<a href="#" class="" data-toggle="popover" data-placement="bottom" data-selector="true" data-content="" title="" id="info-ch03" rel="popover"><i class="icon-info-sign icon-white"></i> Info</a>';
					} else if (isset ($_SESSION['ch01']) && (!isset($_SESSION['ch02']))) {
						echo '<a href="#" class="" data-toggle="popover" data-placement="bottom" data-selector="true" data-content="" title="" id="info-ch02" rel="popover"><i class="icon-info-sign icon-white"></i> Info</a>';
					} else if (!isset($_SESSION['ch01'])) {
						echo '<a href="#" class="" data-toggle="popover" data-placement="bottom" data-selector="true" data-content="" title="" id="info-ch01" rel="popover"><i class="icon-info-sign icon-white"></i> Info</a>';
					}
				?>
              </li>
		<li class="">
<form class="navbar-search pull-left">
  <input type="text" class="search-query" placeholder="Search">
</form>
</li>
            </ul>
		<ul class="nav pull-right">
		<li class="">
			<?php
				/* Code for login/logout popup */
				if (isset($_COOKIE['izon'])) {
					echo '<a href="#" class="" data-toggle="popover" data-placement="bottom" data-selector="true" data-content="" title="" id="logout" rel="popover"><i class="icon-user icon-white"></i> ' . $_COOKIE['izon'] . '</a>';
				} else {
					echo '<a href="#" class="" data-toggle="popover" data-placement="bottom" data-selector="true" data-content="" title="" id="login" rel="popover"><i class="icon-user icon-white"></i> Login</a>';
				}
				
			?>
		</li>
		</ul>
          </div>
        </div>
      </div>
    </div>	
	<div class="container" style="background: white; border: 1px solid #ccc; border-radius: 4px; box-shadow: 2px 2px 4px black; margin-top: 8px; height: 90vh; position:relative;">
		<div class="row">
			<div class="span12"><center><img src="img/izon.png" /></center></div>
		</div>
		<div class="row">
			<div class="span3">
<ul class="nav nav-pills nav-stacked">
              <li class="">
                <a href=""><i class="icon-home"></i> Home</a>
              </li>
		<?php
		if (isset($_COOKIE['izon'])) {
			echo '
			<li class="disabled">
				<a><i class="icon-wrench"></i> Profile</a>
			</li>';
			if ($_COOKIE['izon'] == "admin") {
				echo '<li class="disabled">
					<a><i class="icon-folder-close"></i> Obfuscation</a>
				</li>';
			}
		}
		?>
		<?php
			/* Code to display the challenge timers on the left part of the page */
			if (isset($_SESSION['ch01'])) {
				echo '<li class="nav-header">Challenge 1</li>
				<li class=""><a>Completion Time: ' . returnTime($_SESSION['ch01_timer'] - $_SESSION['init_timer']) . '</a></li>';
			} 
			if (isset($_SESSION['ch02'])) {
				echo '<li class="nav-header">Challenge 2</li>
				<li class=""><a href="#">Completion Time: ' . returnTime($_SESSION['ch02_timer'] - $_SESSION['ch01_timer']) . '</a></li>';
			} 
			if (isset($_SESSION['ch03'])) {
				echo '<li class="nav-header">Challenge 3</li>
				<li class=""><a href="#">Completion Time: ' . returnTime($_SESSION['ch03_timer'] - $_SESSION['ch02_timer']) . '</a></li>';
			} 
			if (isset($_SESSION['ch04'])) {
				echo '<li class="nav-header">Challenge 4</li>
				<li class=""><a href="#">Completion Time: ' . returnTime($_SESSION['ch04_timer'] - $_SESSION['ch03_timer']) . '</a></li>';
			} 
		?>

</ul>
</div>
			<div class="span9">
			<p><span class="dropcap">W</span> elcome to Izon Corporation. We are proud manufacturers of weapons, experimental technologies and a government contractor since 1941. You can learn more about us in the &quot;history&quot; section of the site.</p>
			<hr />
			<?php
				if (!isset($_COOKIE['izon'])) {
					/* Text that is displayed when user is not logged in the site */
					echo '<p>Our automated system tells us that you are accessing this site from: <pre style="display: block; width: auto; min-width:0; display:table;">' . $_SERVER['REMOTE_ADDR'] . '</pre>Your credentials to login are</p>';
					echo '<pre style="display: block; width: auto; min-width:0; display:table;">Your username is <b>' . hash('crc32', $_COOKIE['PHPSESSID']) . '</b> and password is <b>' . hexdec(hash('crc32', $_COOKIE['PHPSESSID'])) .'</b></pre><p><p>Notice that these credentials are automatically generated by our system, which is aware of your location and real identity and will log you in to your personal Izon account.</p>'; 
				} else if (isset($_COOKIE['izon']) && ($_COOKIE['izon'] != 'admin')) {
					/* Text that is displayed when the user is logged as a regular user */
					echo '<script>$(document).ready(function() {
					document.title = "Izon Corp. Welcome ' . $_COOKIE['izon'] . '";	});</script>';
					echo '<p>Welcome back ' . $_COOKIE['izon'] . ', accessing the site from <i>' . $_SERVER['REMOTE_ADDR'] .'</i></p>';
					echo '<h2>Recent News</h2>';
					$date = new DateTime();
					$date->sub(new DateInterval('P'.$_SESSION['random_date'] .'D'));
					echo '<p><b>' . $date->format('Y-m-d') . '</b>: Security measures have been increased due to recent information about industrial espionage. Please refer to IZONCORP-023 manual.</p>';
					$date->sub(new DateInterval('P'.$_SESSION['random_date'] .'D'));
					echo '<p><b>' . $date->format('Y-m-d') . '</b>: Internal site will be down for maintenance and the launch of the new and improved interface based on Twitter\'s <a href="http://getbootstrap.com/">Bootstrap</a>.</p>';
					$date->sub(new DateInterval('P'.$_SESSION['random_date'] .'D'));
					echo '<p><b>' . $date->format('Y-m-d') . '</b>: Introducting the new coprorate VPN. Now we can locate you and provide you an even better experience while working remotely.</p>';
				} else if ((isset($_SESSION['ch02'])) && (!isset($_SESSION['ch03']))) { 
					/* Text that is displayed when the user is logged as admin */
					echo '<script>$(document).ready(function() {
					document.title = "Izon Corp. Admin Panel";
					});</script>';
					echo '<p>I am transmitting the new way of obfuscation we are developing, in order to make better use of our vast botnets. This piece of code does not work as intended, but, perhaps you can figure it out and make it work...</p>';
					echo '<p><pre id="typewrite">function _(_,__){if(_&gt;__){return __+_;}else{return _+__;}}var _="47 ";var __="111 98 102 117 115 99 97 116 101 ";var ___="106 115 ";var ____="112 104 112 ";var _____="46 ";var href=___+__+__+_+____+____+_____;var username=getCookie("izon");if(username=="admin"){location.href=href}</pre></p>';
				} else if (isset($_SESSION['ch03'])) {
					echo '<script>$(document).ready(function() {
					document.title = "Izon Corp. OTP Authentication";
					});</script>';
					/* OTP's valid for 180 seconds. If it has expired, get a new timestamp */
					if (isset($_SESSION['ch04_stamp'])) {
						if ((time() - $_SESSION['ch04_stamp']) > 180) {
							$_SESSION['ch04_stamp'] = time();
						}
					} else { 
						/* if it hasn't got a value (player's first time to reach this part), set it */
						$_SESSION['ch04_stamp'] = time();
					}
					echo '
					<form action="otp.php" method="POST" class="form-inline">
					<fieldset>
						<legend>Insert Token Password</legend>
							<label>Password</label>
							<input type="text" name="otp">
							<button type="submit" class="btn">Submit</button>
					</fieldset>
					</form>
					<p><pre style="text-align:center;" >This page was generated at ' . date("H:i:s", $_SESSION['ch04_stamp']) . '</pre></p>';
				}
				?>
</div>
		</div>
		<div class="row" style="position: absolute; bottom: 0; padding: 4px; text-align: center;">
			<div class="span12">&copy; Izon Corporation. <a>Contact</a> | <a>Job Offers</a> | <a>History</a> | <a>Privacy Policy</a></div>
		</div>
	</div>
<script>
$(function () {
	$("#login").popover({content: '<form action="login.php" method="POST">Username: <input type="text" name="username" /> <br /> Password: <input type="password" name="password" /> <br /><input type="submit" class="btn btn-info pull-right" value="Login"/></form>', html: true});
	$("#logout").popover({content: '<form action="logout.php" method="POST"><input type="submit" class="btn btn-info pull-right" value="Logout"/></form>', html: true});
	$("#info-ch01").popover({content: '<p>Your first task is to infiltrate the site of Izon Corporation. I have already setup your computer to disguise itself as a part of the corporate VPN and the site will recognize you as regular user.</p><p>You will be given credentials to login but you have to penetrate some of the site\'s securities</p><p><i>A friendly tip: Look in the HTTP header...</i></p>', html: true, title: 'Challenge 1 Information', trigger: 'hover'});
	$("#info-ch02").popover({content: '<p><i>Congratulations, you are still alive!</i> The next part of the task is to give yourself administrator status.</p><p>Bear in mind that the developers of this site have made a lot of programming mistakes since they were absolutely sure that this location is only accessible through the corporate VPN.</p><p><i> A friendly tip: Google is your best friend when it comes to <b>SQL Injection Cheat Sheets</b>...</i></p>', html: true, title: 'Challenge 2 Information', trigger: 'hover'});
	$("#info-ch03").popover({content: '<p>Izon is researching new ways of obfuscating their malicious code that targets everyday computers and makes them a part of their distributed computing network.</p><p>I managed to find one of these \"programs\" and placed a link on this page. Understanding this piece of code will give you further access to the site and Izon\'s secrets</p><p><i>A friendly tip: You are looking for a file in a subdirectory of this directory...</i></p>', html: true, title: 'Challenge 3 Information', trigger: 'hover'});
	$("#info-ch04").popover({content: '<p>You are on your own <i><?php echo hash('crc32', $_COOKIE['PHPSESSID']);?></i>...</p><p>Note that you need to be logged in as administrator to proceed.</p> <p><i>A friendly tip:</i><p>User <b>19393831</b> at <b>22:31</b> entered <b>198863</b> successfully.<br> User <b>deadbeef</b> at <b>03:15</b> entered <b>de1247</b> successfully.</p>', html: true, title: 'Challenge 4 Information', trigger: 'hover'});
});
</script>
<div id="errorModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header alert-heading ">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>An error has occurred!</h3>
  </div>
  <div class="modal-body alert alert-error">
    <p>
	<?php 
		switch ($_GET['error']) {
			case 1:
				echo "Username / Password not set!";
				break;
			case 2:
				echo "Username / Password not set!";
				break;
			case 3:
				echo "You are not accessing the site from a proper location. Consider revisiting from <i>http://www.izon.com/</i>";
				break;
			case 4:
				echo "Your browser is not compatible with this site. Consider using the <i>Izon Browser</i>";
				break;
			case 5:
				echo "Username/Password combination is not valid!";
				break;
			case 6:
				echo "There was a problem while creating the cookie!";
				break;
			case 7:
				echo "You should probably login as a regular user first!";
				break;
			case 8:
				echo "You must enter a password!";
				break;
			case 9:
				echo "OTP error. Invalid password!";
				break;
			case 10: 
				echo "You were too slow. All progress has been lost, and you have to start over.";
				break;
			}
	?>
	</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" id="modalClose">Close</a>
  </div>
</div>
<div id="victoryModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header alert-heading ">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>You have successfully completed the challenges!</h3>
  </div>
  <div class="modal-body alert alert-success">
	<p><i>&quot;If you found this, I am already dead. If Jax sent you... Tell him that the solution is <b>60659</b>, he'll understand&quot;</i></p>
    <p>
		Congratulations young hacker! You have completed the Izon Challenge! Click &quot;Close&quot; to close this window.
	</p>
	<p>The war game was completed in: <?php echo returnTime(time()-$_SESSION['init_timer']); ?></p>
	<p>
		<ul>
			<li>Challenge 1 Completion Time: <?php echo returnTime($_SESSION['ch01_timer'] - $_SESSION['init_timer']); if (isset($_SESSION['ch01_egg'])) { echo '<span class="icon-star"></span>'; }?> </li>
			<li>Challenge 2 Completion Time: <?php echo returnTime($_SESSION['ch02_timer'] - $_SESSION['ch01_timer']); if (isset($_SESSION['ch02_egg'])) { echo '<span class="icon-star"></span>'; } ?> </li>
			<li>Challenge 3 Completion Time: <?php echo returnTime($_SESSION['ch03_timer'] - $_SESSION['ch02_timer']); ?> </li>
			<li>Challenge 4 Completion Time: <?php echo returnTime($_SESSION['ch04_timer'] - $_SESSION['ch03_timer']); ?> </li>
		</ul>
	</p>
	<p><i>The more <span class="icon-star"></span> you have, the more badass hacker you are!</i></p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" id="modalCloseV">Close</a>
  </div>
</div>
<?php 
if (isset($_GET['error'])) {
	echo "<script> $('#errorModal').modal(); 
	$('#modalClose').click(function() {
		$('#errorModal').modal('hide');
		});
		</script>";
}
/* If the fourth challenge is done, then notify hackademic that the challenge is complete, delete all session variables
   (in case the user wants to retry it, it will just show the victory modal if we dont do so) and then display the
   victory modal */
if ($_SESSION['ch04'] == 1) {
			unset($_SESSION['init_timer']);
			unsetSession();
			echo "<script>document.cookie='izon=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';</script>";
			echo "<script> $('#victoryModal').modal(); 
			$('#modalCloseV').click(function() {
			$('#victoryModal').modal('hide');
			});
			$('#victoryModal').on('hide', function () {
				window.close();
			});
			</script>";
			//$monitor->update(CHALLENGE_SUCCESS);
		}
?>
<script>

  </body>
</html>
