<html>
<head>
</head>
<body bgcolor="#000000">
<?php
include '../sql-connections/db-creds.inc';
echo "<center>";
@error_reporting(0);
if(isset($_GET['id']))
$id = $_GET['id'];
@$con = mysql_connect($host,$dbuser,$dbpass);
if (!$con)
{
    echo "Failed to connect to MySQL: " . mysql_error();
}

	$sql="DROP DATABASE IF EXISTS $dbname1";
	if (mysql_query($sql))
		{echo "Old database purged if exists"; echo "<br><br>\n";}
	else 
		{echo "Error purging database: " . mysql_error(); echo "<br><br>\n";}

	$sql="CREATE database $dbname1 CHARACTER SET `gbk` ";
	if (mysql_query($sql))
		{echo "Creating New database successfully";echo "<br><br>\n";}
	else 
		{echo "Error creating database: " . mysql_error();echo "<br><br>\n";}

include '../sql-connections/functions.php';
 
$sql="CREATE TABLE IF NOT EXISTS $dbname1.$table
		(
                id INT(2) UNSIGNED NOT NULL DEFAULT 1,
		sessid CHAR(32) PRIMARY KEY NOT NULL,
		$secret_key CHAR(32) NOT NULL,
		tryy INT(11) UNSIGNED NOT NULL DEFAULT 0 
		)";
	if (mysql_query($sql))
		{echo "Creating New Table '$table' successfully";echo "<br><br>\n";}
	else 
		{echo "Error creating Table: " . mysql_error();echo "<br><br>\n";}

$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; 
$sec_key = num_gen(24, $characters);
$hash = md5(rand(0,100000));


$sql="INSERT INTO $dbname1.$table VALUES (1, '$hash', '$sec_key', 0)";
        if (mysql_query($sql))
		{echo "Inserted data correctly  into table '$table'";echo "<br><br>\n";}
	else 
		{echo "Error inserting data: " . mysql_error();echo "<br><br>\n";}

echo "Inserted secret key '$secret_key' into table ";echo "<br><br>\n";

if(isset($id))
header( "refresh:0;url=$id" );

?>
</body>
</html>
