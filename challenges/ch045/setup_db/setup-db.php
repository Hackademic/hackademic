<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome To The World of Pentesters !</title>
</head>
<div>
    <body background="../patience.jpg"<center>
<div/>
<div style=" margin-top:20px;color:#FFFFFF; font-size:24px; text-align:center"> 
Welcome&nbsp;&nbsp;&nbsp;
<font color="#FFFFFF">  </font>
<br>
</div>

<div style=" margin-top:10px;color:#FFFFFF; font-size:23px; text-align:left">
<font size="3" color="#FFFFFF">
<center>Wait a bit.. Setting up database !<center>
<br><br> 


<?php
//including the Mysql connect parameters.
include("db-creds.inc");
echo "<center>";



$con = mysql_connect($host,$dbuser,$dbpass);
if (!$con)
  {
  die('Could not connect to DB, check the creds in db-creds.inc: ' . mysql_error());
  }




//@mysql_select_db('mysql',$con)	
	
//purging Old Database	
	$sql="DROP DATABASE IF EXISTS TripDawki";
	if (mysql_query($sql))
		{echo "Old database 'TripDawki' purged if exists"; echo "<br><br>\n";}
	else 
		{echo "Error purging database: " . mysql_error(); echo "<br><br>\n";}


//Creating new database TripDawki
	$sql="CREATE database `TripDawki` CHARACTER SET `gbk` ";
	if (mysql_query($sql))
		{echo "Creating New database 'TripDawki' successfully";echo "<br><br>\n";}
	else 
		{echo "Error creating database: " . mysql_error();echo "<br><br>\n";}

//creating table users
$sql="CREATE TABLE TripDawki.students (id int(3) NOT NULL AUTO_INCREMENT, student_name varchar(20) NOT NULL, payment varchar(20) NOT NULL, PRIMARY KEY (id))";
	if (mysql_query($sql))
		{echo "Creating New Table 'USERS' successfully";echo "<br><br>\n";}
	else 
		{echo "Error creating Table: " . mysql_error();echo "<br><br>\n";}


//creating table emails
$sql="CREATE TABLE TripDawki.test
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
$sql="INSERT INTO TripDawki.students (id, student_name, payment) VALUES ('1', 'nikhil_karve', 'PAID'), ('2', 'zook_bluetooth', 'PAID'), ('3', 'messi_pentester', 'PAID'), ('4', 'soumya_babe', 'PAID'), ('5', 'kayden_clark', 'NOT-PAID'), ('6', 'Dulton_coder', 'PAID'), ('7', 'wag_ankit', 'PAID'), ('8', 'sergio_ramos', 'PAID'), ('9', 'chris_ronaldo', 'NOT-PAID'), ('10', 'pique_deff', 'NOT-PAID'), ('11', 'lewandowski_striker', 'PAID'), ('12', 'Mesut_ozil', 'PAID'), ('13', 'Ross_geller', 'PAID'), ('14', 'shubhangi_melody', 'PAID'), ('15', 'tripjeet_crush', 'NOT-PAID'), ('16', 'sudo_leet', 'PAID')";
	if (mysql_query($sql))
		{echo "Inserted data correctly into table 'USERS'";echo "<br><br>\n";}
	else 
		{echo "Error inserting data: " . mysql_error();echo "<br><br>\n";}



//inserting data
//$sql="INSERT INTO `TripDawki`.`emails` (id, email_id) VALUES ('1', 'TheGaminAddict@Gamers.com'), ('2', 'Linuxlovers@linux.com'), ('3', 'veryfunny@funny.com'), ('4', 'lovers@lovetime.com'), ('5', 'TimeIs@precious.com'), ('6', 'dallu@aditi.com'), ('7', 'superheroes@best.com'), ('8', 'theadmin@admin.com'),  ('9', 'newone@user.com'),  ('10', 'food@besties.com'),  ('11', 'cubers_world@DeskTest.com'),  ('12', 'thenewadmin@new.com'),  ('13', 'sunil@shankhala.com'),  ('14', 'fourneen@newgmail.com')";
//	if (mysql_query($sql))
//		{echo "Inserted data correctly  into table 'EMAILS'";echo "<br><br>\n";}
//	else 
//		{echo "Error inserting data: " . mysql_error();echo "<br><br>\n";}



//including the Challenges DB creation file.
?>

<font color = #FFFFFF>
</font>
</div>
</body>
</html>
