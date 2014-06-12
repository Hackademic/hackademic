<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Alien Control Room</title>
</head>
<body>

<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

if(isset($_GET['abort']))
{
	echo 'Congratulations';
	$monitor->update(CHALLENGE_SUCCESS, $_GET);
}
else{
	$connect=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

	if(isset($_POST['com_pass']))
	{
		//user can not update/delete anything,also no result is shown to him,multiple sql statements separated by semi-colonare disabled by the use of mysqli_query()
		$query="SELECT * FROM users WHERE  id=1 and password='".$_POST['com_pass']."';";
		$result= mysqli_query($connect,$query);
		if($result->num_rows>0)
		{
			echo "<h2>Welcome Commander</h2><br /> Mission to destroy planet in progress<br/> 
				<a href='qsazlkd.php?abort=1'>Abort Mission</a>";
		}
		else
		{
			$monitor->update(CHALLENGE_FAILURE, $_GET);
			echo 'Commander Login<br/><br/>';
			echo '
				<form method="post">
				Password: <input name="com_pass" type="password" />
				</form>';
		}
	}

	else{
		echo 'Commander Login<br/><br/>';
		echo '
			<form method="post">
			Password: <input name="com_pass" type="password" />
			</form>';
	}
}
?>

</body>
</html>
