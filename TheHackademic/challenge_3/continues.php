<?php 
	//echo "Wait a few, this site is under construction";
	#print_r($_POST);
	$amt = $_POST["amount"];
	echo "<br/>";
	if($amt == 70){
		header("Location: false.php");
	}
	else if($amt > 70 || $amt == 0){
		header("Location: almost.php");
	}
	else if($amt < 70){
	 	header("Location: true.php");
	}
	#exit;
?>


