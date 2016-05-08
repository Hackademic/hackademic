<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

// The student needs to put the field 'access' to 'admin'.
$solution = 'admin';
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

$error = '';
if(isset($_POST['desk']) && isset($_POST['phone'])) {
	// Limits the phone field to numeric value in order
	// to have only one possible field for an SQL injection (the desk field).
	if(is_numeric($_POST['phone']) && strpos($_POST['desk'], '<') === false) {
		if(strpos($_POST['desk'], '\'') === false) {
			$_SESSION['desk'] = $_POST['desk'];
			$_SESSION['phone'] = $_POST['phone'];
		} else {
			// Regex to simulate the outputs of a real SQL injection:
			$regex = "/^(\w*)'\s*,\s*(\w+)\s*=\s*'(\w*)$/";
			$matched = preg_match($regex, $_POST['desk'], $matches);
			if($matched) {
				$desk_value = $matches[1]; // The new desk value.
				$targeted_field = $matches[2]; // The name of the field targeted by the SQL injection.
				$field_value = $matches[3]; // The new value for the field targeted
				$fields = array('first_name', 'last_name', 'desk', 'phone', 'access', 'department');
				if(in_array($targeted_field, $fields)) {
					$_SESSION['desk'] = $desk_value;
					$_SESSION[$targeted_field] = $field_value;
					$_SESSION['phone'] = $_POST['phone'];
					$answer = $field_value;
					$validator->validateSolution($answer);
				} else {
					$validator->failChallenge();
					// Simulates the error that happen in a real case situation.
					$error = 'SQL error: unknown column.';
				}
			} else {
				$validator->failChallenge();
				// Simulates the error that happen in a real case situation.
				$error = 'SQL error: incorrect SQL syntax.';
			}
		}
	} else {
		$validator->failChallenge();
		$error = 'Incorrect value entered.';
	}
}

$firstName = getValue('first_name', 'John');
$lastName = getValue('last_name', 'Smith');
$department = getValue('department', 'IT');
$desk = getValue('desk', 'C11');
$phone = getValue('phone', '488');
$access = getValue('access', 'normal');

function getValue($name, $default) {
	if(isset($_SESSION[$name])) {
		return $_SESSION[$name];
	}
	return $default;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Laser Printer 4800FT</title>
	<link rel="stylesheet" type="text/css" href="data/style.css">
	<script type="text/javascript">
		function admin() {
			alert('You need to be logged in as Admin to see this page.');
		}
	</script>
</head>
<body>
	<?php include('common.html'); ?>
	<section id="main">
		<h2>Account Settings</h2>
		<form method="post">
			<label>First name:</label>
			<input type="text" name="first_name" disabled value="<?= $firstName ?>"><br/>
			<label>Last name:</label>
			<input type="text" name="last_name" disabled value="<?= $lastName ?>"><br/>
			<label>Department:</label>
			<input type="text" name="department" disabled value="<?= $department ?>"><br/>
			<label>Desk:</label>
			<input type="text" name="desk" value="<?= $desk ?>"><br/>
			<label>Phone number:</label>
			<input type="text" name="phone" value="<?= $phone ?>"><br/>
			<label>Account type:</label>
			<input type="text" name="access" disabled value="<?= $access ?>"><br/>
			<?php
				if($error != '') {
					echo '<p style="color:red;">'.$error.'</p>';
				}
			?>
			<input type="submit" value="Update">
		</form>
	</section>
</body>
</html>
