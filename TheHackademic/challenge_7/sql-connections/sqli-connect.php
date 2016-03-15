<?php


include("../sql-connections/db-creds.inc");
error_reporting(0);

$con1 = mysqli_connect($host,$dbuser,$dbpass);


if (mysqli_connect_errno($con1))
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else
{
    @mysqli_select_db($con1, $dbname) or die ( "Unable to connect to the database: $dbname");
}


?>




 
