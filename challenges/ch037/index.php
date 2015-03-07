<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 17</title>
</head>

<body background="background.jpg" style="margin-left:35px">
<center>
<img src="calendar.png">

<hr width='70%'>
<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

$service_enabled=0;
extract($_GET);
if($archives==1 or isset($year))
{	
	if($service_enabled!=1)
	{
		echo 'Currently, the archives service is disabled.<br/><b>Error:</b> Variable $service_enabled is not set,couldn\'t start the service <!-- Developer Note:In the current version, we are using the extract() function to get the request parameters.This increases the ease of coding.Please adopt to this style of coding -->  ';
	}
	else
	{
		echo 'Select the year to view the archive: 
		<form method="get">
		<select name="year">
		<option value="2013">2013</option>
		<option value="2012">2012</option> 
		<option value="2011">2011</option> 
		<option value="2010">2010</option> 
		</select>
		<input type="submit" value="View Calendar"/>
		</form>';
		if(isset($year))
		{
			list($yearno, $command) = split(';',$year);
			if(is_numeric($yearno))
			{
				if( $yearno<2010 or $yearno>2014 )
				{
					echo "cal: year ".$yearno." not in range 2010..2014";
				}
				else
				{
					echo '<div style="font-size:200%;"><pre>';
					//display this calendar for all other years.
					echo $yearno.'<br/>';
					include('cal2.txt');
					echo '</pre></div>';
				}	
			}
			else
			{
				echo 'cal: not a valid year '.$yearno;
			}
			echo '<br/>';
			if($command=='ls')
			{
				echo '<h2>background.jpg calendar.png index.php savedpassword.txt</h2>';
			}
			else if($command!='')
			{
				echo $command.': you don\'t have permissions to execute this specific command';
			}
			echo '<br/>';
		
		} 
	}
}
else if($settings==1)
{	
	if(isset($_POST['password']))
	{
	if($_POST['password']=='yaaramiadmin123')
	{
		$monitor->update(CHALLENGE_SUCCESS);
		echo '<h2>Congratulations!!</h2><br>';
	}
	else
	{	
		$monitor->update(CHALLENGE_FAILURE);
		echo 'Wrong Password<br><br>';
	}
	}
	echo '
	Enter the password to change the settings:<br/>
	<form method="post">
	<input type="password" name="password" />
	<input type="submit" value="submit"/>
	</form>
	';
}
else
{
echo '<div style="font-size:200%;"><pre>';
include('cal.txt');
echo '</pre></div>';
}
?>
<h2>
<a href='?settings=1'>Change Settings</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href='?archives=1'>Calendar Archives</a>
</h2>

</center>

</body>
</html>
