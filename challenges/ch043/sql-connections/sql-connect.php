<?php

//including the Mysql connect parameters.
include("db-creds.inc");
@error_reporting(0);
@$con = mysql_connect($host,$dbuser,$dbpass);
// Check connection
if (!$con)
{
    echo "Failed to connect to MySQL: " . mysql_error();
}


    @mysql_select_db($dbname,$con) or die ( "Unable to connect to the database: $dbname");






$sql_connect = "SQL Connect included";

$form_title_in="Please Login to Continue";
$form_title_ns="New User";
$feedback_title_ns="New User";
$form_title_ns= "Less-24";


?>




 
