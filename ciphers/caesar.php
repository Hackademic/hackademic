<?php
header("Cache-Control: no-cache, must-revalidate");

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT,$_GET);
$_SESSION['init'] = true;



function caesar_enc($str)
{	
	$arr1 = str_split($str);
		
	$str2 = "";
		
	foreach ($arr1 as $value)
	{
		
		if ((ord($value)>=ord('A') && ord($value)<=ord('Z')) || (ord($value)>=ord('a') && ord($value)<=ord('z')))
		{			
			if ((ord($value)>=ord('X') && ord($value)<=ord('Z')) || (ord($value)>=ord('x') && ord($value)<=ord('z')))
			{
				$value = chr(ord($value)-26);
			}	
			
			$str2=$str2 . chr(ord($value)+3); 		
		} 
	}
	
	return $str2;   
}

function caesar_dec($str)
{		
	$arr1 = str_split($str);
	
	$str2 = "";	
	
	foreach ($arr1 as $value)
	{			
		if ((ord($value)>=ord('A') && ord($value)<=ord('Z')) || (ord($value)>=ord('a') && ord($value)<=ord('z')))
		{
			
			if ((ord($value)>=ord('A') && ord($value)<=ord('C')) || (ord($value)>=ord('a') && ord($value)<=ord('c')))
			{
				$value = chr(ord($value)+26);
			}			
						
		    $str2=$str2 . chr(ord($value)-3); 		
		}
	}	
	
	return $str2;   
}
?>

<html>
<head>
	<title>Caesar Cipher</title>
	<link rel=stylesheet type="text/css" href="style.css">
</head>

<script language="JavaScript">
var NumberOfPhrases = 30
var phrases = new BuildArray(NumberOfPhrases)

phrases[1] = "WHATABEAUTIFULDAY"
phrases[2] = "IHAVETOGOTOTHESUPERMARKETTOMMOROW"
phrases[3] = "ITISRAININGTODAYIHAVETOTAKEANUMBRELLA"
phrases[4] = "DONOTDRINKALCOHOLWHENDRIVING"
phrases[5] = "JUSTREMEMBEREVERYTHINGHAPPENSFORAREASON"
phrases[6] = "INEVERYTHINGDOTOOTHERSWHATYOUWOULDHAVETHEMDOTOYOU"
phrases[7] = "LOVEYOURENEMIESITMAKESTHEMANGRY"
phrases[8] = "SAVEWATERDRINKBEER"
phrases[9] = "IAMNOTWEIRDIAMGIFTED"
phrases[10] = "ANGRYPEOPLENEEDSHUGSORSHARPOBJECTS"
phrases[11] = "GOODFRIENDSDONOTLETYOUDOSTUPIDTHINGSALONE"
phrases[12] = "SILENCEISTHEBESTREPLYTOAFOOL"
phrases[13] = "SOMEONEISHAPPYWITHLESSTHANWHATYOUHAVE"
phrases[14] = "ACLEANHOUSEISTHESIGNOFABROKENCOMPUTER"
phrases[15] = "THEREAREPEOPLESOPOORTHATTHEONLYTHINGTHEYHAVEISMONEY"
phrases[16] = "ITALWAYSSEEMSIMBOSSIBLEUNTILITISDONE"
phrases[17] = "THEWORDLISTENCONTAINSTHESAMELETTERSASTHEWORDSILENT"
phrases[18] = "LETYOURPASTMAKEYOUBETTERNOTBITTER"
phrases[19] = "IUSEDTOHAVEANOPENMINDBUTMYBRAINSKEPTFALLINGOUT"
phrases[20] = "ACONCLUSIONISTHEPLACEWHEREYOUGOTTIREDOFTHINKING"
phrases[21] = "WINNINGISNOTEVERYTHINGBUTTHEEFFORTTOWINIS"
phrases[22] = "SUCCESSCOMESBEFOREWORKONLYINTHEDICTIONARY"
phrases[23] = "PERFECTIONCOMESFROMEXPERIENCEANDAEXPERIENCEFROMMISTAKES"
phrases[24] = "THETIMETOMAKEFRIENDSISBEFOREYOUNEDDTHEM"
phrases[25] = "HEWHOSMILESINACRISISHASFOUNDSOMEONETOBLAME"
phrases[26] = "EVERYMORNINGISTHEDAWNOFANEWERROR"
phrases[27] = "FOLLOWYOURHEARTBUTTAKEYOURBRAINWITHYOU"
phrases[28] = "OVERTHINKINGLEADSTONEGATIVETHOUGHTS"
phrases[29] = "GODISNEVERTOBUSYTOLISTENDONOTBETOOBUSYTOTALKHIM"
phrases[30] = "STRONGPEOPLEDONOTPUTOTHERSDOWNTHEYLIFTTHEMUP"

function BuildArray(size){
    this.length = size
    for (var i = 1; i <= size; i++){
        this[i] = null}
    return this
}

function RandomPhrase(frm) {
   
    var rnd = Math.ceil(Math.random() * NumberOfPhrases)
    frm.str.value = phrases[rnd]
}

function clear_form_elements(ele) {

    tags = ele.getElementsByTagName('input');
    for(i = 0; i < tags.length; i++) {
        switch(tags[i].type) {
            case 'password':
            case 'text':
                tags[i].value = '';
                break;
            case 'checkbox':
            case 'radio':
                tags[i].checked = false;
                break;
        }
    }
   
    tags = ele.getElementsByTagName('select');
    for(i = 0; i < tags.length; i++) {
        if(tags[i].type == 'select-one') {
            tags[i].selectedIndex = 0;
        }
        else {
            for(j = 0; j < tags[i].options.length; j++) {
                tags[i].options[j].selected = false;
            }
        }
    }

    tags = ele.getElementsByTagName('textarea');
    for(i = 0; i < tags.length; i++) {
        tags[i].value = '';
    }
   
}
</script>

<body background="img/background.jpg" bottommargin="0" leftmargin="0" marginheight="0" marginwidth="0" rightmargin="0" topmargin="0">

<center><table width="765" height="100%" cellpadding="0" cellspacing="0" border="0" background="img/mainbackground.jpg"><tr valign="top"><td>

<table width="764" height="97" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
<td width="248"><img src="img/templogo.jpg" width="248" height="97" border="0" alt=""></td>
<td width="100%" background="img/toplogobg.jpg"><img src="img/toplogobg.jpg" width="22" height="97" border="0" alt=""></td>
	</tr>
</table>
<table width="764" height="42" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
<td width="169"><img src="img/left1.jpg" width="169" height="42" border="0" alt=""></td>
<td width="100%" background="img/left1bg.jpg"><img src="img/left1bg.jpg" width="20" height="42" border="0" alt=""></td>
	</tr>
</table>

<table width="764" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
<td width="150">
<ul><em><strong>Algorithms</strong></em><BR>
&nbsp; <li><a href="caesar.php">Caesar Cipher</a><BR>
&nbsp; <li><a href="polybius.php">Polybius Square</a><BR>
&nbsp; <li><a href="vigenere.php">Vigenere Table</a><BR>
</ul>
<img src="img/menudivider.jpg" width="150" height="6" border="0" alt=""><BR>
</td>
<td width="10">&nbsp;</td>
<td width="744">

<h1>Caesar Cipher</h1><BR>
<p><b>The Caesar Cipher</b> belongs in the category of cryptograms of monoalphabetic replacement and it is based on the replacement of each letter of alphabet with another that is "x" places right in the alphabet from itself. 
<p>This method took her name from Julius Caesar. He used it for his private correspondence but also for military aims. As it happens with all cryptograms of monoalphabetic replacement, the Caesar cipher is easy to break.
 In modern implementation, it does not actually provide any security in communication.
<img src="img/caesar.jpg" align="right">
<p>The historian Suetonius describes with details one of the types of cryptographic substitution that used by Julius Caesar. According to this type,
 he replaced each letter of the message with the three subsequent positions letter in the alphabet. This type of substitution is called Caesar permutational cipher or simply Caesar cipher.
 Even if Suetonius mentions only a type of permutation at three places, if someone uses any permutation between 1 and 23 positions, can be created 23 separately cryptograms. 
<p>An advantage is the easy implementation of method from the sender and from the recipient. While a disadvantage is the fact that provides
 no security level as there are only 23 possible keys, the exact number of shifts of letters. Consequently the message is decrypted easily.
<p>Here you will use a cryptogram where each letter of the original text is replaced with a three (3) positions letter in front of the alphabet. 
</p><BR><BR>

<form method="post" name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
<strong>Plain text:</strong><br><textarea name="str" rows="3" cols="40">
<?php

if(isset($_POST['str']))$_POST['str']=strtoupper($_POST['str']);

if(isset($_POST['Decrypt']))
{	
	if(isset($_POST['e_str']))  
	{		
    	echo caesar_dec($_POST['e_str']); 
	}
	
	else if(isset($_POST['str']))  
	{
    		echo $_POST['str']; 
	}
}

else if(isset($_POST['str']))  
{
    echo $_POST['str']; 
}	
?></textarea><BR><BR>
<strong>Encrypted text:</strong><br><textarea name="e_str" rows="3" cols="40">
<?php

if(isset($_POST['Encrypt']))
{	
	if(isset($_POST['str']))  
	{		
    	echo caesar_enc($_POST['str']); 
	}
	
	else if(isset($_POST['e_str']))  
	{
    	echo ($_POST['e_str']); 
	}
}

else if(isset($_POST['e_str']))  
{
    echo $_POST['e_str']; 
}
?></textarea>
<BR><BR><BR><BR>
<input type="submit" name="Encrypt" value="Encryption"  />&nbsp;&nbsp;
<input type="submit" name="Decrypt" value="Decryption"  /><BR><BR>
<input type="button" onClick="RandomPhrase(document.form1)" value="Random Phrase">&nbsp;&nbsp;
<input type="button" value="Clear" onclick="clear_form_elements(this.form)" />
</form>

<BR><BR><BR><BR><BR><BR>
<center> Copyright (C) Ntinoulis Giorgos &nbsp;&nbsp; 2013-2014</center>

</td>
<td width="10">&nbsp;</td>
	</tr>
</table>
</td></tr></table></center>
</body>
</html>