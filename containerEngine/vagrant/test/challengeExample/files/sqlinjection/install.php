<?php
$con = mysql_connect('localhost', 'root', '');
mysql_query('CREATE DATABASE test22');

mysql_select_db('test22');


// Installation
mysql_query("CREATE TABLE cars (
		`id` int,
		`name` varchar(100),
		`cost` int,
		`codename` varchar(100)
	);");


mysql_query("INSERT INTO `cars` VALUES('1', 'maruti', '400000', 'mazakuzi');");
mysql_query("INSERT INTO `cars` VALUES('1', 'ferrari', '180000000', 'irakuriti');");
mysql_query("INSERT INTO `cars` VALUES('1', 'honda', '1200000', 'globalski');");
mysql_query("INSERT INTO `cars` VALUES('1', 'BMW', '3600000', 'rishipisi');");
mysql_query("INSERT INTO `cars` VALUES('1', 'mercedez', '4000000', 'holasposki');");
mysql_query("INSERT INTO `cars` VALUES('1', 'audi', '6000000', 'yokshire');");



unlink('install.php');