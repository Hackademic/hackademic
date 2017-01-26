<?php

include("db-creds.inc");
@error_reporting(0);
@$con = mysql_connect($host,$dbuser,$dbpass);

if (!$con)
{
    echo "Failed to connect to MySQL: " . mysql_error();
}

@mysql_select_db($dbname,$con) or die ( "Unable to connect to the database: $dbname");

?>




 
