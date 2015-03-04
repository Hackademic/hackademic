<?php

//include_once dirname(__FILE__).'/../../init.php';
//session_start();
//require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
//$monitor->update(CHALLENGE_INIT, $_GET);
//$_SESSION['init'] = true;

		$db_link = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$database_name = "hack14_".hash('crc32', $_COOKIE['PHPSESSID']);
		$db_link->query("CREATE DATABASE " . $database_name);
		/* And then create a new user*/
		$db_link->query("CREATE USER '" . $database_name  ."'@'" . DB_HOST . "' IDENTIFIED BY 'hackademic_password'");
		$db_link->query("REVOKE ALL PRIVILEGES, GRANT OPTION FROM '" . $database_name  ."'@'" . DB_HOST . "'");
		$db_link->query("GRANT ALL ON " . $database_name .".* TO '" . $database_name  ."'@'" . DB_HOST . "'");
		$db_link->query("FLUSH PRIVILEGES");
		$table1 = "CREATE TABLE IF NOT EXISTS `MobiStore_Members` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(12) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;";
		$table2="CREATE TABLE IF NOT EXISTS `MobiStore_Mobiles` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Mobile` varchar(12) NOT NULL,
  `Company` varchar(15) NOT NULL,
  `Image` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
";

		$db_link->select_db($database_name);
		$db_link->query($table1);
		$db_link->query($table2);
		
		$sql1 = "INSERT INTO `MobiStore_Members` (`Id`, `Name`, `Email`, `Password`) VALUES
(1, 'Admin', 'qgtdfsdszpwwr2@exzzecs.com', '8b1a9953c4611296a827abf8c47804d7'),
(3, 'User1', 'user1@gmail.com', '7cca8faba7eae9cfc163496e15877b6d'),
(4, 'User2', 'user2@gmail.com', 'c6174f233857b6846a16aaf1c5dbb816');
";
		$db_link->query($sql1);

		$sql2 = "INSERT INTO `MobiStore_Mobiles` (`Id`, `Mobile`, `Company`, `Image`) VALUES
(1, 'iPhone 3GS', 'Apple', 1),
(2, 'iPhone 4', 'Apple', 1),
(3, 'iPhone 5s', 'Apple', 1),
(4, 'Galaxy S III', 'Samsung', 2),
(5, 'W 2014', 'Samsung', 2),
(6, 'Lumia 636', 'Nokia', 3),
(7, 'Asha 301', 'Nokia', 3);
";
		$db_link->query($sql2);
		$db_link->close();

?>
