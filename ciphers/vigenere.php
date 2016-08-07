<?php
header("Cache-Control: no-cache, must-revalidate");

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT,$_GET);
$_SESSION['init'] = true;



function vigenere_enc($text, $key)
{	
	if ($text==null || $key==null)return "";
	
	$arr1 = str_split($text);	
	$arr2 = str_split($key);	
	
	$str= "";
	$i=0;
	
	foreach ($arr1 as $value)
	{
			$str  = $str . $arr2[$i];
			$i++;
			
			if ($i==count($arr2))$i=0;	
	}
	
	$arr2 = str_split($str);	
	$str="";	
	$i=0;
	
	if (count($arr2)>=1)
	
	foreach ($arr1 as $value)
	{		
		if (ord($value)>=ord('A') && ord($value)<=ord('Z'))
		{					
			if (ord($arr2[$i])>=ord('A') && ord($arr2[$i])<=ord('Z'))
			{
				$k=ord($value)+ord($arr2[$i])-ord('A');
				if ($k>ord('Z'))$k = $k-26;
				$str=$str . chr($k);
			}			
		}		
		$i++;
	}
		
	return $str; 
}

function vigenere_dec($text, $key)
{	
	if ($text==null || $key==null)return "";	
	
	$arr1 = str_split($text);	
	$arr2 = str_split($key);	
	
	$str= "";
	$i=0;
	
	foreach ($arr1 as $value)
	{
			$str  = $str . $arr2[$i];
			$i++;
			
			if ($i==count($arr2))$i=0;	
	}	
	
	$arr2 = str_split($str);	
	$str="";	
	$i=0;
	
	if (count($arr2)>=1)
	
	foreach ($arr1 as $value)
	{		
		if (ord($value)>=ord('A') && ord($value)<=ord('Z'))
		{				
			if (ord($arr2[$i])>=ord('A') && ord($arr2[$i])<=ord('Z'))
			{
				$k=ord($value)-ord($arr2[$i])+ord('A');
				if ($k<ord('A'))$k = $k+26;
				$str=$str . chr($k);
			}			
		}		
		$i++;
	}		
	return $str;
}
?>
<html>
<head>
	<title>Vigenere Table</title>
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
        this[i] = -1}
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

<img src="img/menudivider.jpg" width="150" height="6" border="0" alt=""><BR>
<ul><em><strong>Algorithms</strong></em><BR>
&nbsp; <li><a href="caesar.php">Caesar Cipher</a><BR>
&nbsp; <li><a href="polybius.php">Polybius Square</a><BR>
&nbsp; <li><a href="vigenere.php">Vigenere Table</a><BR>
</ul>
<img src="img/menudivider.jpg" width="150" height="6" border="0" alt=""><BR>
</td>
<td width="10">&nbsp;</td>
<td width="744">
<h1>Vigenere Table</h1><BR>

<table border="2" align="center">
<tr>
<td><th colspan="26">Plain Text
<tr>
<th rowspan="26">K<br>e<br>y
<?php
	$count = 91;
	$char=65;
	
	for ($k = $char; $k < $count; $k++)	
	{
		$m=0;
		for ($i = $k; $i < $count; $i++) 
		{
			?>
			<td>
			<font face="arial" size="1">
			<?php echo chr($i);
			$m++;
		}
		for ($i = $char; $i < $count-$m; $i++) 
		{
			?>
			</font>
			<td>
			<font face="arial" size="1">
			<?php echo chr($i);
		}?>
		<tr>
	<?php
	}
	?>
</font>	
</table>
<BR>


<p>In a Caesar cipher, each letter of the alphabet is shifted by some positions, for instance, in a Caesar cipher of shift 3, 
the letter A will be D, B will be E, Y will be B and so on. 
The Vigenere cipher consists of several Caesar ciphers in sequence with different shift values.</p>
<p> To encrypt, a table of alphabets can be used as a tabula Recta, Vigenere square or Vigenere table. It consists of the alphabet written out 26 times in different rows,
each alphabet shifted cyclically to the left compared to the previous alphabet, that correspond to the 26 possible Caesar ciphers.
At various points in the process of encryption, the cipher uses a different alphabet in every row.
The alphabet used at each point depends on a repeating keyword.</p>
<p> For example, suppose that the encrypted plaintext is:  &nbsp;&nbsp;ATTACKATDAWN</p>
<p>The person sending the message chooses a keyword and repeats it until it matches the length of plaintext, 
for example, the keyword  "lemon": &nbsp;&nbsp;LEMONLEMONLE</p>
<p>Each row starts with a key letter. The remainder of the row holds the letters A to Z (in shifted order).
 Although there are 26 key rows shown, you will only use as many keys (different alphabets) as there are unique letters in the key string,
 here just 5 keys, {L, E, M, O, N}. For successive letters of the message, we are going to take successive letters of the key string,
 and encipher each message letter using its corresponding key row. Choose the next letter of the key, 
 go along that row to find the column heading that matches the message character; the letter at the intersection of [key-row, msg-col] is the enciphered letter.</p>

<p>For example, the first letter of the plaintext, A, is paired with L, the first letter of the key. So use row L and column A of the Vigenere square, namely L.
 Similarly, for the second letter of the plaintext, the second letter of the key is used; the letter at row E and column T is X.
 The rest of the plaintext is enciphered in a similar fashion:
<br><br>
Plain text    : ATTACKATDAWN<br>
Key           : LEMONLEMONLE<br>
Cipher text   : LXFOPVEFRNHR<br></p>
</p>Decryption is performed by going to the row in the table corresponding to the key, finding the position of the ciphertext letter in this row, 
and then using the column's label as the plaintext. For example, in row L (from LEMON), the ciphertext L appears in column A, which is the first plaintext letter.
 Next we go to row E (from LEMON), locate the ciphertext X which is found in column T, thus T is the second plaintext letter.</p>
<BR><BR>

<form method="post" name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
<strong>Plain Text:</strong><br><textarea name="str" rows="3" cols="40">
<?php

if(isset($_POST['str']))$_POST['str']=strtoupper($_POST['str']);
if(isset($_POST['e_str']))$_POST['e_str']=strtoupper($_POST['e_str']);
if(isset($_POST['key']))$_POST['key']=strtoupper($_POST['key']);

if(isset($_POST['Decrypt']))
{	
    if (vigenere_dec($_POST['e_str'],$_POST['key'])=="")echo $_POST['str'];
	
	else echo vigenere_dec($_POST['e_str'],$_POST['key']);
}
else if(isset($_POST['str']))  
{
    echo $_POST['str']; 
}	
?></textarea><BR><BR>
<strong>Key:</strong><br><input type="text" size="45" name="key" value='
<?php
if(isset($_POST['key']))  
{
    echo $_POST['key']; 
}
?>'><BR><BR>
<strong>Encrypted Text:</strong><br><textarea name="e_str" rows="3" cols="40">
<?php

if(isset($_POST['Encrypt']))
{
    if (vigenere_enc($_POST['str'],$_POST['key'])=="")echo $_POST['e_str'];
	else echo vigenere_enc($_POST['str'],$_POST['key']);
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
<BR><BR><BR>
</td>
<td width="10">&nbsp;</td>
	</tr>
</table>
</td></tr></table></center>
</body>
</html>