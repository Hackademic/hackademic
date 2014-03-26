<?php
/* κάνουμε include το αρχείο "config.inc.php" του hackademic
ουτως ώστε να έχουμε πρόσβαση στα definition DB_HOST, DB_NAME κλπ τα οποία 
μας δίνουν την δυνατότητα να συνδεθούμε στον MySQL server και ξεκινάμε και το session 
για να έχουμε πρόσβαση στις μεταβλητές του*/
session_start();
include_once dirname(__FILE__).'/../../init.php';		
include_once 'config.inc.php';
//require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");

class User {

	/* Δημόσιες μεταβλητές username και password οι οποίες χρησιμοποιούνται για να κάνουμε
	validate ένα χρήστη που προσπαθεί να συνδεθεί στο site */
	public $username;
	public $password;
	
	private $database_name;
	/* Ο κονστράκτοράς μας */
	function __construct() {
		session_start();
		/* Ανοίγουμε μια νέα σύνδεση στον SQL Server με τα στοιχεία που πήραμε απο το
		αρχείο config.inc.php. 
		ΣΗΜΑΝΤΙΚΟ!!!1 (ενα θαυμαστικό): Ο χρήστης πρέπει να έχει δικαιώματα για δημιουργία 
		νέας βάσης δεδομένων και δικαιώματα για να σβήνει βάσεις δεδομένων*/
		$db_link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		/* Βάσει της τιμής του cookie του hackademic, παίρνουμε ένα string (για την ακρίβεια παίρνουμε
		το crc32 της τιμής του) το οποίο θα χρησιμοποιηθεί ώς όνομα βάσης δεδομένων και όνομα του χρήστη στην SQL */
		$this->database_name = hash('crc32', $_COOKIE['PHPSESSID']);
		
		/* Φτιάχνουμε μια νέα βάση δεδομένων για να μπορέσει να δουλέψει εκεί */
		$db_link->query("CREATE DATABASE hack_" . $this->database_name);
		
		/* Φτιάχνουμε ένα νέο χρήστη στην mysql ο οποίος θα μπορεί να συνδεθεί στην βάση δεδομένων (για να μην 
		γίνει privilege abuse και να μην υπάρξει κενό ασφαλείας) */
		$db_link->query("CREATE USER 'hack_" . $this->database_name  ."'@'" . DB_HOST . "' IDENTIFIED BY 'hackademic_password'");
		
		/* Αφαιρούμε όλα τα privileges απο τον χρήστη που φτιάξαμε και την επιλογή GRANT (με την οποία μπορει 
		να δώσει privileges στον εαυτό του ή σε κάποιον άλλο χρήστη) */
		$db_link->query("REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'hack_" . $this->database_name  ."'@'" . DB_HOST . "'");
				
		/* Και τέλος του δίνουμε privileges μόνο στην νέα βάση δεδομένων που έχουμε δημιουργήσει */
		$db_link->query("GRANT ALL ON hack_" . $this->database_name .".* TO 'hack_" . $this->database_name  ."'@'" . DB_HOST . "'");
		$db_link->query("FLUSH PRIVILEGES");
		
		/* Δημιουργούμε την δομή του πίνακα users 
		Βήμα πρώτο, δημιουργούμε το query της δομή του*/
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
	
		/* Βήμα Δεύτερο: Επιλέγουμε την βάση που δημιουργήσαμε */
		$db_link->select_db("hack_" . $this->database_name);
		
		/* Και τέλος, δημιουργούμε τον πίνακα κάνοντας query */
		$db_link->query($table);
		
		/* Έπειτα, δημιουργούμε δύο εγγραφές, μία για τον χρήστη admin και μία για τον απλό χρήστη */
		$sql = 'INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `password`, `joined`, `last_visit`, `is_activated`, `type`, `token`) VALUES (NULL, \'admin\', \'kapoios\', \'kati@kapou.com\', \'enadiotria\', \'2014-01-15 00:00:00\', \'2014-01-23 00:00:00\', \'1\', \'1\', \'1\')';
		$db_link->query($sql);
		$sql = 'INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `password`, `joined`, `last_visit`, `is_activated`, `type`, `token`) VALUES (NULL, \''.$this->database_name . '\', \'kapoios\', \'kati@kapou.com\', \''.hexdec($this->database_name).'\', \'2014-01-15 00:00:00\', \'2014-01-23 00:00:00\', \'1\', \'1\', \'1\')';
		$db_link->query($sql);
		
		/* και κλείνουμε το connection */
		$db_link->close();
		
	}
	
	function __destruct() {
		/* Ανοίγουμε μια νέα σύνδεση στον SQL Server με τα στοιχεία που πήραμε απο το
		αρχείο config.inc.php. 
		ΣΗΜΑΝΤΙΚΟ!!!1 (ενα θαυμαστικό): Ο χρήστης πρέπει να έχει δικαιώματα για δημιουργία 
		νέας βάσης δεδομένων και δικαιώματα για να σβήνει βάσεις δεδομένων*/
		$db_link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		/* Διαγράφουμε την προσωρινή βάση δεδομένων */
		$db_link->query("DROP DATABASE hack_" . $this->database_name);
		
		/* Διαγράφουμε τον χρήστη που έχουμε δημιουργήσει */
		$db_link->query("DROP USER 'hack_" . $this->database_name  ."'@'" . DB_HOST . "'");
		//χρειαζόμασε κι ένα FLUSH γιατι κάποιες φορές υπάρχει πρόβλημα λόγω του: http://bugs.mysql.com/bug.php?id=28331
		$db_link->query("FLUSH PRIVILEGES");
		/* Και τέλος, κλείνουμε το connection */
		
		$db_link->close();
	}
	public function login() {
		/* Κατ' αρχάς ελέγχουμε αν ο χρήστης έχει συμπληρώσει τα πεδία username και password της φόρμας */
		if ((!isset($_POST['username'])) || (!isset($_POST['password'])) ) {
			$this->sendPostData(1);
		}
		/* Κατα δεύτερον ελέγχουμε οτι τα πεδία αυτά δεν έιναι κενά */
		if ((($_POST['username'])=="") || (($_POST['password']) == "")) {
			$this->sendPostData(2);
		}
		if (!isset($_SESSION['ch01'])) {	//Για να μην γίνεται πολλές φορές το Header Forgery 
			/* Κατά τρίτον, ελέγχουμε για τον σωστό referer (Challenge 1: HTTP Header Forgery) */
			if ($_SERVER['HTTP_REFERER'] != "http://www.izon.com/") {
				$this->sendPostData(3);
			}
			/* Κατα τέταρτον, ελέχγουμε για τον σωστό browser (Challenge 1: HTTP Header Forgery) */
			if ($_SERVER['HTTP_USER_AGENT'] != "Izon Browser" ) {
				$this->sendPostData(4);
			}
		}
		/* Δημιουργούμε μια νέα σύνδεση στην sql, με τα στοιχεία του χρήστη που έχουμε φτιάξει έτσι ώστε
		να έχουμε πρόσβαση στην προσωρινή βάση δεδομένων */
		$db_link = new mysqli(DB_HOST, "hack_" . $this->database_name, 'hackademic_password', "hack_" . $this->database_name);
		
		/* Βάζουμε τα user/pass στις μεταβλητές της κλάσης */
		$this->username = $_POST['username'];
		$this->password = $_POST['password'];
		/* Κάνουμε ένα query στην βάση δεδομένων για να δούμε άν όντως υπάρχει το συγκεκριμένο username/password στην βάση δεδομένων
		Ακριβώς εδώ μπορεί να γίνει sql injection.*/
		$our_query = "SELECT * FROM users WHERE	username='" . $this->username . "' AND password='" . $this->password . "'";
		$result = $db_link->query($our_query);
		
		/* Εαν η sql μας επιστρέψει περισσότερες απο μηδεν εγγραφές (αυτό γίνεται επίτηδες για να καταλάβουμε ότι ο χρήστης μας έκανε
		sql injection */
		
		if ($result->num_rows > 0) {
			/* Λέμε στην sql να μας επιστρέψει μόνο την πρώτη γραμμή για να δούμε ποιο είναι το username */
			$row = $result->fetch_row();
			/* Και την εκχωρούμε στην μεταβλητή username της κλάσης */
			$this->username = $row[1];
			/* Αν ο χρήστης έχει κάνει login ως admin (successful sql injection)
			αλλά δεν έχει περάσει το πρώτο challenge, τότε πρέπει να τον γυρίσουμε πίσω και να του
			πούμε πως δεν μπορεί να το κάνει ακόμη αυτό */
			if ($this->username == 'admin') {
				/* αυτό επιτυγχάνεται με τον έλεγχο της μεταβλητής $_SESSION['ch01']
				που κανονικά παίρνει τιμή λίγο πιο κάτω*/
				if (!isset($_SESSION['ch01'])) {
					$this->sendPostData(7);
				} else {
					$_SESSION['ch02']=1;
					/* Αν το timer δεν έχει τιμή του δίνουμε ( η άλλη περίπτωση είναι να ξανακάνει login ο χρήστης άρα και να 
					ξαναλύσει το challenge ) */
					if (!isset($_SESSION['ch02_timer'])) { $_SESSION['ch02_timer']=time(); }
				}
			} else if ($this->username = hash('crc32', $_COOKIE['PHPSESSID'])) {
				$_SESSION['ch01'] = 1;
				/* Αν το timer δεν έχει τιμή του δίνουμε ( η άλλη περίπτωση είναι να ξανακάνει login ο χρήστης άρα και να 
				ξαναλύσει το challenge ) */
				if (!isset($_SESSION['ch01_timer'])) { $_SESSION['ch01_timer']=time(); }
				/* Μάλλον ο χρήστης μας ήταν πολύ μπροστά κι έκανε injection και στο πρώτο challenge!!! */
				if ($this->password != hexdec($this->username)) {
					$_SESSION['ch01_egg'] = 1;
				}
			}
			/* Έπειτα φτιάχνουμε το cookie για να μείνει logged in ο χρήστης μας */
			$cook = setcookie('izon',  $this->username, time()+3600);
			/* Αν όλα πήγαν καλά, ανακατευθύνουμε τον χρήστη στο index */
			if ($cook) {
				header("Location: index.php");
			} else {
			/* Πες στον χρήστη οτι υπήρξε πρόβλημα κατα την δημιουργία του cookie */
				$this->sendPostData(6);
			}
		} else {
			/* δεν βρέθηκε κανένας χρήστης, οπότε ενημέρωσε τον χρήστη μας πως το username/password combination δεν είναι εγκυρο */
			$this->sendPostData(5);
		}
	}
	/* βοηθητική function που χρησιμοποιείται για να κάνει redirect τον χρήστη με ένα κωδικό σφάλματος */
	private function sendPostData($errorNumber) {
		header("Location: index.php?error=" . $errorNumber);
		exit();
	}
}

$user = new User();
$user->login();
$user = NULL;

?>
