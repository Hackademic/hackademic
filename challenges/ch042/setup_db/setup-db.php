<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome To The World Hackers</title>
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
	$sql="DROP DATABASE IF EXISTS waymessier_db";
	if (mysql_query($sql))
		{echo "Old database 'waymessier_db' purged if exists"; echo "<br><br>\n";}
	else 
		{echo "Error purging database: " . mysql_error(); echo "<br><br>\n";}


//Creating new database waymessier_db
	$sql="CREATE database `waymessier_db` CHARACTER SET `gbk` ";
	if (mysql_query($sql))
		{echo "Creating New database 'waymessier_db' successfully";echo "<br><br>\n";}
	else 
		{echo "Error creating database: " . mysql_error();echo "<br><br>\n";}

//creating table users
$sql="CREATE TABLE waymessier_db.users (id int(3) NOT NULL AUTO_INCREMENT, username varchar(20) NOT NULL, password varchar(20) NOT NULL, PRIMARY KEY (id))";
	if (mysql_query($sql))
		{echo "Creating New Table 'USERS' successfully";echo "<br><br>\n";}
	else 
		{echo "Error creating Table: " . mysql_error();echo "<br><br>\n";}


//creating table emails
$sql="CREATE TABLE waymessier_db.emails
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
$sql="INSERT INTO waymessier_db.users (id, username, password) VALUES ('1', 'TheGamer', 'C.O.D'), ('2', 'scrtusr', 'mint_cinnamon'), ('3', 'soumya', 'fu**inglol'), ('4', 'Adamnew', 'Evenew'), ('5', 'Preciouslate', 'PreTimeLate'), ('6', 'DultonThe', 'WowDulton_coder'), ('7', 'Newbatman', 'catty_woman'), ('8', 'admin', 'TheAdminPassw0rd'), ('9', 'Joey', 'Tribbiani'), ('10', 'Chandler', 'Bing'), ('11', 'Matthew', 'Perry'), ('12', 'Monica', 'Geller'), ('13', 'Ross', 'Geller1'), ('14', 'Phoebe', 'Buffay')";
	if (mysql_query($sql))
		{echo "Inserted data correctly into table 'USERS'";echo "<br><br>\n";}
	else 
		{echo "Error inserting data: " . mysql_error();echo "<br><br>\n";}



//inserting data
$sql="INSERT INTO `waymessier_db`.`emails` (id, email_id) VALUES ('1', 'TheGaminAddict@Gamers.com'), ('2', 'Linuxlovers@linux.com'), ('3', 'veryfunny@funny.com'), ('4', 'lovers@lovetime.com'), ('5', 'TimeIs@precious.com'), ('6', 'dallu@aditi.com'), ('7', 'superheroes@best.com'), ('8', 'theadmin@admin.com'),  ('9', 'newone@user.com'),  ('10', 'food@besties.com'),  ('11', 'cubers_world@DeskTest.com'),  ('12', 'thenewadmin@new.com'),  ('13', 'sunil@shankhala.com'),  ('14', 'fourneen@newgmail.com')";
	if (mysql_query($sql))
		{echo "Inserted data correctly  into table 'EMAILS'";echo "<br><br>\n";}
	else 
		{echo "Error inserting data: " . mysql_error();echo "<br><br>\n";}

?>

<font color = #FFFFFF>
</font>
</div>
</body>
</html>
