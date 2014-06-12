<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 13</title>
<center>
<body bgcolor="black" style="margin-left:35px">
<img src="save_planet.png">
</center>
<font color="green">
</head>
<body>

<h2>
<hr>
<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;

?>
The commander of the aliens has ordered his army to destroy a planet. You are on a mission to save the planet.(Yes!!, you are a Jedi Knight). You found a secret message sent by the commander. The message is in the Alien language,you have to decode it and save the planet. 
<br />
<br />
Your machine has already decoded some part of the message.
<br />
<br />
<center>
Svool Hlowrvih (Hello Soldiers)
<br />
<br />
Ovg fh Nzixs (Let us March)
<br />
<br />
Ivnvnyvi gsv ulooldrmt,gsrh rh z hvxivg zmw srtsob xlmurwvmgrzo nvhhztv.Glwzb rh gsv wzb dv ziv dzrgrmt uli,dv droo wvhgilb gsv kozmvg.Blf zoo droo ivxrvev gsv liwvih uiln nb xlmgilo illn zg &lt;z sivu= "jhzaopw.ksk"&gt;Zorvm Svzwjfzigvih
<br />
<br />
</center>

Hint: Aliens use famous substitution ciphers to build their language.
<br />
<br />
<?php
//echo 'Remember the following,this is a highly confidential message.Today is the day we are waiting for,we will destroy the planet.You all will recieve the orders from my control room at <a href= "qsazlkd.php">Alien Headquarters</a>';
?>


</body>
</html>
