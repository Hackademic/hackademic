<?php
print_r($_POST);
if( isset( $_POST[ 'Submit' ]  ) ) {
	// Get input
	echo $_REQUEST['ip'];

	echo "<br/>";
	$target = trim($_REQUEST[ 'ip' ]);
	echo $target;

	// Set blacklist
	$substitutions = array(
		'&'  => '',
		'('  => '',
		')'  => '',
		'| ' => '',
		//'-'  => '',
		'_'  => '',
		'$'  => '',
		'; '  => '',
		'`'  => '',
		'||' => '',        
	);

	// Remove any of the charactars in the array (blacklist).
	$target = str_replace( array_keys( $substitutions ), $substitutions, $target );

	echo $target;

	// Determine OS and execute the ping command.
//	if( stristr( php_uname( 's' ), 'Windows NT' ) ) {
		// Windows
//		$cmd = shell_exec( 'ping  ' . $target );
//	}
//	else {
		// *nix
		$cmd = shell_exec( 'whatweb ' . $target );
//	}

	// Feedback for the end user
	$html .= "<pre>{$cmd}</pre>";
	//echo $html;
}

?>
