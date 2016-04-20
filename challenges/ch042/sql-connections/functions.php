<?php
//including the Mysql connect parameters.
include("db-creds.inc");
include("sql-connect-1.php");


function num_gen($string_length, $characters)
{
	$string = '';
 	for ($i = 0; $i < $string_length; $i++) 
	{
      		$string .= $characters[rand(0, strlen($characters) - 1)];
 	}
	return $string;
}

$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';  

$table = num_gen(10, $characters) ;


$secret_key = "secret_".num_gen(4, $characters);


function table_name()
{
	include '../sql-connections/db-creds.inc';
	include '../sql-connections/sql-connect-1.php';
	$sql="SELECT table_name FROM information_schema.tables WHERE table_schema='$dbname1'";
	$result=mysql_query($sql) or die("error in function table_name()".mysql_error());
	$row = mysql_fetch_array($result);
	if(!$row)
	die("error in function table_name() output". mysql_error());
	else
	return $row[0];
}


function column_name($idee)
{
	include '../sql-connections/db-creds.inc';
	include '../sql-connections/sql-connect-1.php';
	$table = table_name();
	$sql="SELECT column_name FROM information_schema.columns WHERE table_name='$table' LIMIT $idee,1";
	$result=mysql_query($sql) or die("error in function column_name()".mysql_error());
	$row = mysql_fetch_array($result);
	if(!$row)
	die("error in function column_name() result". mysql_error());
	else
	return $row[0];
}


function data($tab,$col)
{
	include '../sql-connections/db-creds.inc';
	include '../sql-connections/sql-connect-1.php';
	$sql="SELECT $col FROM $tab WHERE id=1";
	$result=mysql_query($sql) or die("error in function column_name()".mysql_error());
	$row = mysql_fetch_array($result);
	if(!$row)
	die("error in function column_name() result". mysql_error());
	else
	return $row[0];
}


function next_tryy()
{
	$table = table_name();
	
	include '../sql-connections/db-creds.inc';
	include '../sql-connections/sql-connect-1.php';
	$sql = "UPDATE $table SET tryy=tryy+1 WHERE id=1";
	mysql_query($sql) or die("error in function next_tryy()". mysql_error());
}

function view_attempts()
{
	include("../sql-connections/sql-connect-1.php");
	$table = table_name();
	$sql="SELECT tryy FROM $table WHERE id=1";
	$result=mysql_query($sql) ;
	$row = mysql_fetch_array($result);
	if(!$row)
	die("error in function view_attempts()". mysql_error());
	else
	return $row[0];	
}

?>
