<?php

 //include_once dirname(__FILE__).'/../../init.php';
 //session_start();
 $db_link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
 $database_name = "hack14_".hash('crc32', $_COOKIE['PHPSESSID']);
 /* Drop our database */
 $db_link->query("DROP DATABASE " . $database_name);
 
 /* Delete the user we've created */
 $db_link->query("DROP USER '" . $database_name  ."'@'" . DB_HOST . "'");
 /* A FLUSH PRIVILEGES is needed, because sometimes problems arise due to: http://bugs.mysql.com/bug.php?id=28331 */
 $db_link->query("FLUSH PRIVILEGES");
 
 /* Finally, close the connection */
 $db_link->close();
 
?>
