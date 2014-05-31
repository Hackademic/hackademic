<!--
/**
 *    ----------------------------------------------------------------
 *    OWASP Hackademic Challenges Project
 *    ----------------------------------------------------------------
 *		Authors:
 *   	  Nikos Danopoulos
 *   	  Spyros Gasteratos
 *    ----------------------------------------------------------------
 */

-->
<html>
	<head>
		<style type="text/css">

.image1 {
    float: left;
}
.form {
    margin: 2em auto auto;
    width: 23%;
}
table {
    float: left;
    margin-left: 4em;
    margin-top: 109px;
}
th, td {
    color: white;
}
form>input:first-child{
    height: 2em;
    width: 100%;
}
form>input:nth-child(2){
 margin: 0.5em auto auto 34%;
	}
	#content{
	   margin: auto;
    width: 68%;
		}
	#fail{
	color: red;
    margin: auto;
    width: 18%;
	}
	.success{
		    clear: both;
    color: green;
    display: block;
    margin: auto;
    text-align: center;
    width: 124%;
		}
		</style>
	</head>
	<body style="background-color:black">
		<?php
		include_once dirname(__FILE__).'/../../init.php';
        session_start();
        require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
        $monitor->update(CHALLENGE_INIT,$_GET);
		$_SESSION['init'] = true;
		?>
		<div id="content">
			<h1 style="color:white;text-align:center">The official Underground Shop!</h1>
			<?php
			if(isset($_POST['secretfiles']) && $_POST['secretfiles']!= ''){
				if( $_POST['secretfiles'] === 'easy' ){
					echo('<h1 class="success" >Congrats!You have successfully completed this challenge</h1>
							<h2>Call me :p</h2>');
					$monitor->update(CHALLENGE_SUCCESS);
				}elseif ($_POST['secretfiles'] != 'easy' ){
					echo('<h1 id="fail">Try again</h1>');
					$monitor->update(CHALLENGE_FAILURE);
				}
			}
			?>
			<img src="guns.jpg" class="image1">
			<?php setcookie("User", "guest");?>
			<table border="1" CELLSPACING="4" CELLPADDING="8" BORDER="2" >
				<tr><th>Admin</th><td>Marcous</td></tr>
				<tr><th>Users</th><td>Nick</td><td>hax0r</td><td>l33t</td></tr>
			</table>
		</div>
			<form method="post" class="form" >
				<input type="text" name="secretfiles" placeholder="Secret Password"/>
				<input type="submit" name="submit" value="Submit"/>
		</form>

	</body>
</html>
