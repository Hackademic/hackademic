<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml1-strict.dtd">
<html>
<head><title>WhatWeb - Next generation web scanner.</title>
<meta http-equiv="Content-Language" content="en-us" />
<meta name="Description" content="WhatWeb online scan. Identify content management systems (CMS), blogging platforms, stats/analytics packages, javascript libraries, web servers, and embedded devices and more." />
<meta name="Keywords" content="whatweb online scanner, whatweb, scan, footprint, fingerprint, webapp, webappsec" />
<meta name="google-site-verification" content="" />
<link rel="stylesheet" type="text/css" href="whatweb.css" />
<link rel="shortcut icon" href="favicon.ico" />
</head>

<div id="container">


<script type="text/javascript" src="whatweb.js"></script>

<div id="header">
<img src="whatweb-heading.jpg" style="width:100%" title="WhatWeb - Next generation web scanner. Identify what websites are running." alt="WhatWeb - Next generation web scanner. Identify what websites are running.">
</div>

<br/>
<br/>

<a href = ".log'in.php" style="text-decoration:none;"><font color = white>login page</a>
<font/>
<br/>
<font color=black>

<div class="body_padded">
  

  	<div class="vulnerable_code_area">
  		
  		<form name="ping" action="#" method="post">
  			<p>
	 			Enter an IP address/Domain:
	 			<input type="text" name="ip" size="30">
	 		<input type="submit" name="Submit" value="Submit">
  			</p>
  		</form>
</div>



<p id="description">WhatWeb is a next generation web scanner.<br/><br/>
WhatWeb recognises web technologies including content management systems (CMS), blogging platforms, statistic/analytics packages, JavaScript libraries, web servers, and embedded devices.<br/><br/>
</p>

</div>
<?php

$vulnerabilityFile = 'index_ind.php';
define('__ROOT__', dirname(dirname(__FILE__)));
echo "<br/>";
//echo __ROOT__;
echo "<br/>";
//echo "check3";
echo "<br/>";

require_once __ROOT__ . "/inside/{$vulnerabilityFile}";
//echo "check2";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";echo "<br/>";echo "<br/>";
?>

<div id="description">
<pre>
<?php echo "{$html}" ?>
</pre>
</div>
</font>
</html>

