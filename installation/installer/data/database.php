<?php
	define("ROOT_PATH",getcwd().'/../../../');

	$path = ROOT_PATH . DIRECTORY_SEPARATOR . 'installation' . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'db.sql';
	$file=fopen($path,"r");
	$str=null;
	while(!feof($file)){
		$line=fgets($file,200);
		$str .= $line;
		if(strstr($line,";")){
			$SQL[] .= $str;
			$str = null;
		}
	}
	$query  = "INSERT INTO users (id,username, full_name, email, password, joined, last_visit,";
	$query .= "is_activated ,type ,token) VALUES (0,'".$_SESSION['admin_username']."', ";
	$query .= "'Administrator','".$_SESSION['admin_email']."','".$_SESSION['admin_password']."', ";
	$query .= "'".date("Y-m-d H-i-s")."','0000-00-00 00:00:00', '1','1','0');";
	$SQL[] = $query;
	$query = "INSERT INTO class_memberships (user_id,class_id) VALUES (0,1)";
	$SQL[] = $query;
?>
