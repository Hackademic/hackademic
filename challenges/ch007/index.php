<?php

/**
 *    ----------------------------------------------------------------
 *    OWASP Hackademic Challenges Project
 *    ----------------------------------------------------------------
 *    Copyright (C) 2010-2011
 *   	  Andreas Venieris [venieris@owasp.gr]
 *   	  Anastasios Stasinopoulos [anast@owasp.gr]
 *    ----------------------------------------------------------------
 */

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>Challenge 007</TITLE>
<center>
	<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="101%" id="AutoNumber1" height="104" background="spoudastes/Banner01.bmp">
	  <tr>
	    <td width="86%" height="104">
	    <p align="center"><img src="index_files/logo.png">
<META http-equiv=Content-Type content="text/html; charset=iso-8859-7">
<SCRIPT language=javascript type=text/javascript>
var NN3 = false;

image1= new Image();
image1.src = "index-items/choffgr.jpg";
image1on = new Image();
image1on.src = "index-items/chongr.jpg";

image2= new Image();
image2.src = "index-items/choffen.jpg";
image2on = new Image();
image2on.src = "index-items/chonen.jpg";

function on3(name)   {
        document[name].src = eval(name + "on.src");
}
function off3(name)  {
        document[name].src = eval(name + ".src");
}
NN3 = true;

function on(name)  {
        if (NN3) on3(name);
}
function off(name)  {
        if (NN3) off3(name);
}</SCRIPT>

<META content="MSHTML 6.00.6000.16608" name=GENERATOR></HEAD>
<BODY background=index_files/background.jpg>
	<?php
		include_once dirname(__FILE__).'/../../init.php';
        session_start();
        require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
        $monitor->update(CHALLENGE_INIT,$_GET['user'],$_GET['id'],$_GET['token']);
?>
  <TR>
    <TD   width="100%">
      <TABLE cellSpacing=0 cellPadding=0 width=766 border=0></TD>
        </TR></TBODY>
      <form action="ch007.php" method="post">
      <br>
        <p align="center"><font color="#6A8295" size="2">Module marks for student:</font>
            <input type="text" name="name" size="20">
            <input type="submit" value="Enter" name="submit">
        </p>
      </form></TD></TR></TBODY></TABLE></center></BODY></HTML>
