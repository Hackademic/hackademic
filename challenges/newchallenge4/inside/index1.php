<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Website's Name</title>
		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" type="text/css" href="contact.css">
		<link href='http://fonts.googleapis.com/css?family=Gentium+Book+Basic' rel='stylesheet' type='text/css'>
	</head>
	<body>
		
		<div id="sideCarNav">
			<div id="mobileNavWrapper" class="nav-Wrapper" >
				<nav id="mobileNavigation"></nav>
			</div>
		</div>
		<div id="siteWrapper" class="clearfix">
		<!--header starts-->
			<header id="header">
				<div class="inner-header">
					<div id="logoWrapper" class="wrapper">
						<h1 id="logoImage">
							<a href="./index.html">
								<img src="images/logo3.png" alt="Narendra-Choudhary">
							</a>
						</h1>
					</div>
					
				</div>
			</header>
			<!--header ends-->
			<!--cover starts-->
			<div class="banner-thumbnail-wrapper ">
				<div class="desc-wrapper">
					<p>
						<em>Let's Get the ball</em>
					</p>
					<p id="big-desc">
						<strong style="letter-spacing: 0.0588235em;">Rolling.</strong>
					</p>
				</div>
			</div>
<?php
//including the Mysql connect parameters.
	include("../sql-connections/sql-connect.php");
if(!isset($_COOKIE['uname']))
	{
	//including the Mysql connect parameters.
	include("../sql-connections/sql-connect.php");

	echo "<br/>";
	echo "<div style=' margin-top:20px;color:#000000; font-size:24px; text-align:center'> Welcome to the Login Page &nbsp;&nbsp;&nbsp;<font color='#FF0000'> </font><br></div>";
	echo "<div  align='center' style='margin:20px 0px 0px 510px;border:20px; background-color:#FFFFFF; text-align:center;width:400px; height:150px;'>";
	echo "<div style='padding-top:10px; font-size:15px;'>";
 	echo "<br/>";

	echo "<!--Form to post the contents -->";
	echo '<form action=" " name="form1" method="post">';

	echo ' <div style="margin-top:15px; height:30px;">Username : &nbsp;&nbsp;&nbsp;';
	echo '   <input type="text"  name="uname" value=""/>  </div>';
  
	echo ' <div> Password : &nbsp; &nbsp; &nbsp;';
	echo '   <input type="password" name="passwd" value=""/></div></br>';	
	echo '   <div style=" margin-top:9px;margin-left:90px;"><input type="submit" name="submit" value="Submit" /></div>';

	echo '</form>';
	echo '</div>';
	echo '</div>';
	echo '<div style=" margin-top:10px;color:#FFF; font-size:23px; text-align:center">';
	echo '<font size="3" color="#000000">';
	echo '<center><br>';
	echo '</center>';






	
function check_input($value)
	{
	if(!empty($value))
		{
		$value = substr($value,0,20); 
		}
		if (get_magic_quotes_gpc())  // Stripslashes if magic quotes enabled
			{
			$value = stripslashes($value);
			}
		if (!ctype_digit($value))   	
			{
			$value = "'" . mysql_real_escape_string($value) . "'";
			}
	else
		{
		$value = intval($value);
		}
	return $value;
	}


	
	echo "<br>";
	echo "<br>";
	
	if(isset($_POST['uname']) && isset($_POST['passwd']))
		{
	
		$uname = check_input($_POST['uname']);
		$passwd = check_input($_POST['passwd']);
		
	

		
		$sql="SELECT  users.username, users.password FROM users WHERE users.username=$uname and users.password=$passwd ORDER BY users.id DESC LIMIT 0,1";
		$result1 = mysql_query($sql);
		$row1 = mysql_fetch_array($result1);
			if($row1)
				{
				echo '<font color= "#000000" font size = 3 >';
				setcookie('uname', base64_encode($row1['username']), time()+3600);	
				header ('Location: index1.php');
				echo "I LOVE YOU COOKIES";
				echo "</font>";
				echo '<font color= "#000000" font size = 3 >';			
				
				echo "</font>";
				echo "<br>";
				print_r(mysql_error());			
				echo "<br><br>";
				echo "test";
				echo "<br>";
				}
			else
				{
				echo '<font color= "#00000" font size="4">';
				print_r(mysql_error());
				echo "<font><b>Invalid credentials<b/><font/>";
				echo "</br>";			
				echo "</br>";
				echo "</font>";  
				}
			}
		
			echo "</font>";  
	echo '</font>';
	echo '</div>';

}
else
{



	if(!isset($_POST['submit']))
		{

		//	print_r($_SERVER);
			echo "<br/>";
			if ( ($_SERVER['HTTP_USER_AGENT'] === 'OurBrowser' ) ) 
			{
			$cookee = $_COOKIE['uname'];
			$format = 'D d M Y - H:i:s';
			$timestamp = time() + 3600;
			echo "<center>";
			echo "<br><br><br>";
			echo "<br><br>";
			echo '<br><font color= "#000000" font size="4">';	
		//	echo "YOUR USER AGENT IS : ".$_SERVER['HTTP_USER_AGENT'];
		//	echo "</font><br>";	
			echo '<font color= "#000000" font size = 5 >';			
			
			$cookee = base64_decode($cookee);
			$cookee1 = '"'. $cookee. '"';
			echo "</font>";
			$sql="SELECT * FROM users WHERE username=$cookee1 LIMIT 0,1";
			$result=mysql_query($sql);
			if (!$result)
  				{
  				die('Issue with your mysql: ' . mysql_error() . "<br/><br/><br/><br/>");
  				}
			$row = mysql_fetch_array($result);
			if($row)
				{
			  	echo '<font color= "black" font size="5">';	
			  	echo "You now have access to your Profile<br/><br/>";
			  	echo '<b>You are logged in as : </b>'. $row['username'];
			  	echo "<br>";
			  	if($row['username'] == "admin"){
			  		echo "<br/><br/><font size = 6 color=green><b>CONGRATS, YOU NAILED IT !<b/><font/>";
			  		echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
			  		die();
			  	}
				echo '<font color= "grey" font size="5">';  	
			  	echo "</font></b>";
				echo "<br>";
				echo 'Your CALL ID is : ' .$row['id'];
			  	}
			else	
				{
				echo "<center><br/>";
				echo "You almost got it";
				echo '<br><br><br>';
				echo "<br><br><b>";
				}
			echo '<center>';
			echo "<br/><br/><br/>";
			echo '<form action="" method="post">';
			echo '<input  type="submit" name="submit" value="Delete Your Cookie!" />';
			echo '</form>';
			echo '</center>';
		    }
		    else{
		    	echo "<center><br/>You have logged in, but unfortunately you cannot access your profile without <b> OurBrowser<b> <center>";
		    	echo "<br/><center>*If you are our customer, you would have our paid browser and you would know how to continue<center>";
		    	echo "<br/>";
			echo '<center>';
			echo "<br/><br/><br/>";
			echo '<form action="" method="post">';
			echo '<input  type="submit" name="submit" value="Delete Your Cookie!" />';
			echo '</form>';
			echo '</center>';
		    }
		}	
	else
		{
		echo '<center>';
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo '<font color= "#FFFF00" font size = 6 >';
		echo " Your Cookie is deleted";
				setcookie('uname', base64_encode($row1['username']), time()-3600);
				header ('Location: index1.php');
		echo '</font></center></br>';
		
		}		


			echo "<br>";
			echo "<br>";
			//header ('Location: main.php');
			echo "<br>";
			echo "<br>";
			
	
}
?>


				<footer id="footer">
				<div class="center-align">
                    <div class="image-grid-container">
                        <div class="row">
                            <div class="col-40 center-align">
                                <a href="" class="social"><img src="use-icon/twitter_32.png"></a>
                                <a href="" class="social"><img src="use-icon/fb_32.png"></a>
                                <a href="" class="social"><img src="use-icon/linkedin_32.png"></a>
                                <a href="" class="social"><img src="use-icon/fb_32.png"></a>
                            </div>
                            <div class="col-60 center">
                                <ul>
                                    <li><a href="">Home</a></li>
                                    <li><a href="">Work</a></li>
                                    <li><a href="">Profile</a></li>
                                    <li><a href="">Resume</a></li>
                                    <li><a href="">Blog</a></li>
                                    <li class="contactli"><a href="">Home</a></li>
                                    <li class="copyli">&copy;2014-15 All Rights Reserved.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
				</div>
			</footer>
		</div>
	</body>
</html>
