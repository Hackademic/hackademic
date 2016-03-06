<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JUST GO </title>
</head>

<div>
  <body background="../images/back.jpg"><center/>
 <div/>
<div style=" margin-top:70px;color:#FFF; font-size:40px ; text-align:center">Welcome to your Aquatic World&nbsp;&nbsp;&nbsp;<font color="#FF0000"></font><br>
<font size="3" color="#FFFF00">
</font>


<br/>




<?php

include("../sql-connections/sql-connect.php");


if(isset($_GET['id']))
{
	$id=$_GET['id'];
	
	$id= blacklist($id);
	//echo "<br>";
	//echo "<br>";
	$hint=$id;

	$sql="SELECT * FROM users WHERE id='$id' LIMIT 0,1";
	$result=mysql_query($sql);
	$row = mysql_fetch_array($result);
	if($id == 8 || $id == 12 || $id == 9 || $id == 2 || $id == 3 || $id == 4 || $id == 5 || $id == 6 || $id == 7 || $id == 10 || $id == 11 || $id == 13 || $id == 14){
		echo "<font size = 5>Nice try :P <font/>" ;
		die();
	}
	if($row)
	{
	  	echo "<font size='5' color= white>";	
	  	echo 'You are logged in as : '. $row['username'];
	  	echo "<br>";
	  	
  	}
	else 
	{
		echo '<font color= "#FFFFFF" size=3>' ;
		print_r(mysql_error());
		echo "</font>";  
	}
}
	else{ 

			header("Location: main_index.php?id=1");
			
			
		}



function blacklist($id)
{
	//$id= preg_replace('/union/',"", $id)
	//$id= preg_replace('/or/i',"", $id);		//strip out OR (non case sensitive)
	//$id= preg_replace('/and/i',"", $id);		//Strip out AND (non case sensitive)
	$id= preg_replace('/[\/\*]/',"", $id);		//strip out /*
	$id= preg_replace('/[--]/',"", $id);		//Strip out --
	$id= preg_replace('/[#]/',"", $id);		//Strip out #
	$id= preg_replace('/[\s]/',"", $id);		//Strip out spaces
	$id= preg_replace('/[\/\\\\]/',"", $id);	//Strip out slashes
	return $id;
}



?>
</font> </div></br></br></br><center>
</br>
</br>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<font size = 5 color = white><b>" We Believe in Security Of Aquatic Animals, and you should too ! "<b/><font/><br/><br/>
</br>
</br>
</br>
<font size='4' color= "#33FFFF">
<?php
?>
</font> 
</center>
</body>
</html>





 
