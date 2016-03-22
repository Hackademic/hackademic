<?php
/* init.php from hackademic allows us to use its functions while
   config.inc.php contains the credentials for the temporary mysql
   connection that allows the injections to be done */
session_start();
//include_once dirname(__FILE__).'/../../init.php';		
include_once 'config.inc.php';
//require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");

class User {

	/* Public variables of the class, meant to store username and password 
	   in order to login */
	public $username;
	public $password;
	
	private $database_name;
	/* Our constructor */
	function __construct() {
		/* A new connection is created to MySQL in order to create the temporary user/database/table
		   used in the injection 
		   IMPORTANT: The user must be able to CREATE/DROP database, CREATE/DROP user (etc, see readme) */
		$db_link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		/* We calculate the CRC32 value of PHPSESSID cookie (this is the unique identifier php assigns to each
		   user's session) in order to use it as database/database username/username in izon challenge */
		$this->database_name = hash('crc32', $_COOKIE['PHPSESSID']);
		
		/* We create a new database */
		$db_link->query("CREATE DATABASE hack_" . $this->database_name);
		
		/* And then create a new user*/
		$db_link->query("CREATE USER 'hack_" . $this->database_name  ."'@'" . DB_HOST . "' IDENTIFIED BY 'hackademic_password'");
		
		/* Remove all privileges from the new user (and GRANT OPTION) so that he cannot mess with the database */
		$db_link->query("REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'hack_" . $this->database_name  ."'@'" . DB_HOST . "'");
				
		/* Finally, we grant him privileges only on our database */
		$db_link->query("GRANT ALL ON hack_" . $this->database_name .".* TO 'hack_" . $this->database_name  ."'@'" . DB_HOST . "'");
		$db_link->query("FLUSH PRIVILEGES");
		
		/* Table creation step one: Structure */
		$table = "CREATE TABLE IF NOT EXISTS `users` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`username` varchar(255) NOT NULL,
		`full_name` varchar(255) NOT NULL,
		`email` varchar(100) NOT NULL,
		`password` varchar(255) NOT NULL,
		`joined` datetime NOT NULL,
		`last_visit` datetime DEFAULT NULL,
		`is_activated` int(1) DEFAULT '0',
		`type` int(10) DEFAULT '0',
		`token` int(10) DEFAULT '0',
		PRIMARY KEY (`username`),
		UNIQUE KEY `id` (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
	
		/* Step Two: Selection of the newly created db */
		$db_link->select_db("hack_" . $this->database_name);
		
		/* Step Three: Creation of the table*/
		$db_link->query($table);
		
		/* Then, we insert two records, one for the admin user and another for the regular user */
		$sql = 'INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `password`, `joined`, `last_visit`, `is_activated`, `type`, `token`) VALUES (NULL, \'admin\', \'kapoios\', \'kati@kapou.com\', \'enadiotria\', \'2014-01-15 00:00:00\', \'2014-01-23 00:00:00\', \'1\', \'1\', \'1\')';
		$db_link->query($sql);
		$sql = 'INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `password`, `joined`, `last_visit`, `is_activated`, `type`, `token`) VALUES (NULL, \''.$this->database_name . '\', \'kapoios\', \'kati@kapou.com\', \''.hexdec($this->database_name).'\', \'2014-01-15 00:00:00\', \'2014-01-23 00:00:00\', \'1\', \'1\', \'1\')';
		$db_link->query($sql);
		
		/* Finally we close the connection */
		$db_link->close();
		
	}
	/* Our Destructor */
	function __destruct() {
		/* As in constructor, open a new connection with a user that has full privileges */
		$db_link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		/* Drop our database */
		$db_link->query("DROP DATABASE hack_" . $this->database_name);
		
		/* Delete the user we've created */
		$db_link->query("DROP USER 'hack_" . $this->database_name  ."'@'" . DB_HOST . "'");
		/* A FLUSH PRIVILEGES is needed, because sometimes problems arise due to: http://bugs.mysql.com/bug.php?id=28331 */
		$db_link->query("FLUSH PRIVILEGES");
		
		/* Finally, close the connection */
		$db_link->close();
	}
	public function login() {
		/* We check if the user send the POST Data correctly */
		if ((!isset($_POST['username'])) || (!isset($_POST['password'])) ) {
			$this->sendPostData(1);
		}
		/* Then, check if he has given values to username/password */
		if ((($_POST['username'])=="") || (($_POST['password']) == "")) {
			$this->sendPostData(2);
		}
		/* If the first challenge is complete, we skip this check in order to simplify the wargame */
		if (!isset($_SESSION['ch01'])) {
			/* First part of the header forgery challenge: check for the correct referrer */
			if ($_SERVER['HTTP_REFERER'] != "http://www.izon.com/") {
				$this->sendPostData(3);
			}
			/* Second part of the header forgery challenge: check for the correct user-agent */ 
			if ($_SERVER['HTTP_USER_AGENT'] != "Izon Browser" ) {
				$this->sendPostData(4);
			}
		}
		/* Open a new connection with the credentials of the temporary user we created in our constructor */
		$db_link = new mysqli(DB_HOST, "hack_" . $this->database_name, 'hackademic_password', "hack_" . $this->database_name);
		
		/* Assign values to class's variables */
		$this->username = $_POST['username'];
		$this->password = $_POST['password'];
		/* And do the query to find our user. Injection happens here */
		$our_query = "SELECT * FROM users WHERE	username='" . $this->username . "' AND password='" . $this->password . "'";
		$result = $db_link->query($our_query);
		
		/* If the result has rows, then we either have a successful login or a successful injection */
		if ($result->num_rows > 0) {
			/* We only need to fetch the first row in order to check the username */
			$row = $result->fetch_row();
			/* and assign it to username variable (it uses $row[1] because username field is the second field of the table) */
			$this->username = $row[1];
			/* If username is admin (successful sql injection), but hasn't gone through the first challenge, 
			   we must send him back, telling him that he cannot do that yet */
			if ($this->username == 'admin') {
				/* This is possible by checking session variable ch01 */
				if (!isset($_SESSION['ch01'])) {
					$this->sendPostData(7);
				} else {
					$_SESSION['ch02']=1;
					/* If all went well, we set the challenge timer in order to display user's progress */
					if (!isset($_SESSION['ch02_timer'])) { $_SESSION['ch02_timer']=time(); }
				}
			/* The other case is when the user tries to login as a regular user with the give username */
			} else if ($this->username = hash('crc32', $_COOKIE['PHPSESSID'])) {
				$_SESSION['ch01'] = 1;
				/* we set the challenge timer in order to display user's progress */
				if (!isset($_SESSION['ch01_timer'])) { $_SESSION['ch01_timer']=time(); }
				/* If the user didn't use the supplied password, he injected his way in the first challenge, give him the easter egg*/
				if ($this->password != hexdec($this->username)) {
					$_SESSION['ch01_egg'] = 1;
				}
			}
			/* Create the cookie in order to have him logged in */
			$cook = setcookie('izon',  $this->username, time()+3600);
			/* If all went well, redirect him to index */
			if ($cook) {
				header("Location: index.php");
				die();
			} else {
				/* Tell him that there was an error, while baking the cookie */
				$this->sendPostData(6);
			}
		} else {
			/* No user found! */
			$this->sendPostData(5);
		}
	}
	/* Helper function that redirects back to index with an error number */
	private function sendPostData($errorNumber) {
		header("Location: index.php?error=" . $errorNumber);
		exit();
	}
}
$user = new User();
$user->login();
$user = NULL;
?>
