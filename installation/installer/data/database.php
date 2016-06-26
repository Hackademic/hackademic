<?php
define("ROOT_PATH", getcwd() . '/../../../');

$path = ROOT_PATH . DIRECTORY_SEPARATOR . 'installation' . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'db.sql';
$SQL[] = file_get_contents($path);
$query = "INSERT INTO users (id,username, full_name, email, password, joined, last_visit, is_activated ,type ,token) VALUES (0,'" . $_SESSION['admin_username'] . "', 'Administrator','" . $_SESSION['admin_email'] . "','" . $_SESSION['admin_password'] . "','" . date("Y-m-d H-i-s") . "','0000-00-00 00:00:00', '1','1','0'); INSERT INTO class_memberships (user_id,class_id) VALUES (0,1);";
$SQL[] = $query;

