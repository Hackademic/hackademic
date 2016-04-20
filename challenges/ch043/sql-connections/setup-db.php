<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SETUP DB</title>
</head>

<div>
    <body background="../patience.jpg"<center>
<div/>

<div style=" margin-top:20px;color:#FFFFFF; font-size:24px; text-align:center"> 
Welcome Coders&nbsp;&nbsp;&nbsp;
<font color="#FFFFFF">  </font>
<br>
<br/>
</div>

<div style=" margin-top:10px;color:#FFFFFF; font-size:23px; text-align:left">
<font size="3" color="#FFFFFF">
<center>Setting up the whole Database.. Wait a Bit !<center>
<br><br> 


<?php

include("db-creds.inc");
echo "<center>";



$con = mysql_connect($host,$dbuser,$dbpass);
if (!$con)
  {
  die('Could not connect to the Database, check the credentials in db-creds.inc: ' . mysql_error());
  }

	$sql="DROP DATABASE IF EXISTS messier_db";
	if (mysql_query($sql))
		{echo "Old database 'messier_db' purged if exists"; echo "<br><br>\n";}
	else 
		{echo "Error purging database: " . mysql_error(); echo "<br><br>\n";}


//Creating new database messier_db
	$sql="CREATE database `messier_db` CHARACTER SET `gbk` ";
	if (mysql_query($sql))
		{echo "Creating New database 'messier_db' successfully";echo "<br><br>\n";}
	else 
		{echo "Error creating database: " . mysql_error();echo "<br><br>\n";}

//creating table users
$sql="CREATE TABLE messier_db.users (id int(3) NOT NULL AUTO_INCREMENT, username varchar(20) NOT NULL, password varchar(20) NOT NULL, PRIMARY KEY (id))";
	if (mysql_query($sql))
		{echo "Creating New Table 'USERS' successfully";echo "<br><br>\n";}
	else 
		{echo "Error creating Table: " . mysql_error();echo "<br><br>\n";}


//creating table emails
$sql="CREATE TABLE messier_db.emails
		(
		id int(3)NOT NULL AUTO_INCREMENT,
		email_id varchar(30) NOT NULL,
		PRIMARY KEY (id)
		)";
	if (mysql_query($sql))
		{echo "Creating New Table 'EMAILS' successfully"; echo "<br><br>\n";}
	else 
		{echo "Error creating Table: " . mysql_error();echo "<br><br>\n";}




//inserting data
$sql="INSERT INTO messier_db.users (id, username, password) VALUES ('1', 'Gamer', 'CallOfDuty'), ('2', 'qwerty', 'qwertypad'), ('3', 'funny', 'lol1234'), ('4', 'Adam', 'Eve'), ('5', 'Precious', 'PreTime'), ('6', 'Dulton', 'Dulton_coder'), ('7', 'batman', 'cattywoman'), ('8', 'chomu', 'tikon@web123'), ('9', 'usernew', 'Password'), ('10', 'noodles', 'chinese'), ('11', 'megaminx', 'megaminx12'), ('12', 'theadmin', 'theadmin123'), ('13', 'sunil', 'shankala'), ('14', 'fourneen', '123456789')";
	if (mysql_query($sql))
		{echo "Inserted data correctly into table 'USERS'";echo "<br><br>\n";}
	else 
		{echo "Error inserting data: " . mysql_error();echo "<br><br>\n";}



//inserting data
$sql="INSERT INTO `messier_db`.`emails` (id, email_id) VALUES ('1', 'TheGaminAddict@Gamers.com'), ('2', 'Linuxlovers@linux.com'), ('3', 'veryfunny@funny.com'), ('4', 'lovers@lovetime.com'), ('5', 'TimeIs@precious.com'), ('6', 'dallu@aditi.com'), ('7', 'superheroes@best.com'), ('8', 'theadmin@admin.com'),  ('9', 'newone@user.com'),  ('10', 'food@besties.com'),  ('11', 'cubers_world@DeskTest.com'),  ('12', 'thenewadmin@new.com'),  ('13', 'sunil@shankhala.com'),  ('14', 'fourneen@newgmail.com')";
	if (mysql_query($sql))
		{echo "Inserted data correctly  into table 'EMAILS'";echo "<br><br>\n";}
	else 
		{echo "Error inserting data: " . mysql_error();echo "<br><br>\n";}



//including the Challenges DB creation file.
include("setup-db-challenge.php");
?>


</font>
</div>
</body>
</html>
