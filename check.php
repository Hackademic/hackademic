


<!DOCTYPE html>
<html lang="en">
<head>
	<?php

?>
	<style>
	c
	{
		padding: 10px 100px 10px 100px;
	}
	</style>

    <meta charset="utf-8">
    <title>Hackademic CMS</title>

    <link rel="shortcut icon" type="image/x-icon" href="/hackademic/assets/images/favicon.png">
    <link rel="stylesheet" type="text/css" href="/hackademic/assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/hackademic/assets/css/pagination.css" />
    <link rel="stylesheet" type="text/css" href="/hackademic/assets/css/base.css" /> 
</head>
<body>
    <div id="main">
		<div id="headerBar">
	   	 <div class="left">
			<div class="pad_top_5 margin_left_25">
			    <a href="http://www.owasp.org" target="_blank">
			    <!-- style used inline because it will not be repeated elsewhere in the webapp -->
				<img id="orglogo" src="/hackademic/assets/images/owasp.png">
			    </a>
			</div>
		 </div>
	   <div class="center pad_25">
			<a href="/hackademic/">
		    	<img id="logo" src="/hackademic/assets/images/logo.png">
			</a>
	    </div>     
	</div>
	<div id="c">
	
		<?php
			// ensure that #setsebool -P httpd_can_network_connect 1 is run on selinux systems
			$host    = "127.0.0.1";
			$port    = 8081;
			$message = "request\n";
			//echo "Message To server :".$message;
			// create socket
			$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
			// connect to server
			$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
			// send string to server
			socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
			// get server response
			$result = socket_read ($socket, 1024) or die("Could not read server response\n");
			echo "Reply From Server  :".$result;
			//close socket
			socket_close($socket);

			$fwdurl = $_GET['fwdurl'];

			$array = explode("/", $fwdurl);
			$array[2] = $array[2].':'.$result;
			$fwdurl = implode("/",$array);

			//echo "<a href = $fwdurl>click here</a>";
			//echo $fwdurl;
			//header("Location: ".$fwdurl);
			echo "<iframe src=$fwdurl  width='900' height='500' algin='left'></iframe>";
		?>
	</div>

</body>
</html>
