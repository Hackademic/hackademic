<?php
define("ROOT_PATH","F:/wamp/www/hackademic");
$path = ROOT_PATH . DIRECTORY_SEPARATOR . 'installation' . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'db.sql';
$file=fopen($path,"r");
$str=null;
while(!feof($file)){
    $line=fgets($file,200);
    $str .= $line;
    if(strstr($line,";")){
        $SQL[]= $str;
        $str=null;
    }
}

$query= "INSERT INTO users (username, full_name, email, password, joined, last_visit,";
$query .="is_activated ,type ,token) VALUES ('".$_SESSION['admin_username']."', ";
$query .="'Administrator','".$_SESSION['admin_email']."','".$_SESSION['admin_password']."', ";
$query .="'".date("Y-m-d H-i-s")."','0000-00-00 00:00:00', '1','1','0');";
$SQL[]=$query;
