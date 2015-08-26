<?php
	// Do installation if not already done
	if (file_exists(__DIR__ .'/install.php')) include __DIR__ .'/install.php';


	$con = mysql_connect('localhost', 'root', '');
	mysql_select_db('test22');
	if (isset($_POST['search'])) {
		$key = $_POST['search'];
		$query = mysql_query("SELECT id, name, cost FROM cars WHERE name = '$key'");
		$data = array();
		while($row = mysql_fetch_array($query)) {
			$data[] = array(
					'id' => $row[0],
					'name' => $row[1],
					'cost' => $row[2],
				);
		}

	}
	$query = mysql_query("SELECT name FROM cars;");
	$cars = array();
	while($row = mysql_fetch_array($query)) {
		$cars[] = $row['name'];
	}
?>
<html>
<head>
<title> SQL Injection Challemge </title>
<body style="text-align: center">
	<div style="margin-top:100px">
	<h1> Get Information about car </h1>
	<p> Search for car name to get information about it!</p>
	</div>

	<div>
		<form action="./" method="POST">
			Car Name <input type="text" name="search" placeholder="car name">
			<br><br>
			<input type="submit" value="search">
		</form>

		<br>
		<br>
		<?php
			if (isset($key)) {
				echo 'search result for <b>' . $key .'</b>';
				echo '<br>';
				echo '<center>';
				echo '<table style="text-align: center; border: 1px solid silver; margin-top:20px">';
				echo '<tr style="border-bottom: 1px solid silver">';
					echo '<th style="width: 100px">id</th>';
					echo '<th style="min-width: 200px">name</th>';
					echo '<th style="min-width: 200px">cost</th>';
				echo '</tr>';

				foreach ($data as $key => $value) {
					echo '<tr>';
						echo '<th>' .$value['id'] .'</th>';
						echo '<th>' .$value['name'] .'</th>';
						echo '<th>$' .$value['cost'] .'</th>';
					echo '</tr>';
				}

				echo '</table>';
				echo '</center>';

			}
		?>

		<br><br>
		We have information about cars: <?php
		$count = count($cars);
		foreach ($cars as $key => $value) {
			echo $value;
			if ($key != $count - 1) echo ', ';
		}
		?>

		<hr>
		We also store <b>codename</b> of each car. Can you find the code name of <b>mercedez</b>!
	</div>

</body>
</head>
</html>
