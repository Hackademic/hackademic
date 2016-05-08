<?php
header("Cache-Control: no-cache, must-revalidate");

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT,$_GET);
$_SESSION['init'] = true;



function polivios_enc($str)
{
	$arr = array(	
					1=>array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E',6=>'F'),
					2=>array(1=>'G',2=>'H',3=>'I',4=>'J',5=>'K',6=>'L'),
					3=>array(1=>'M',2=>'N',3=>'O',4=>'P',5=>'Q',6=>'R'),
					4=>array(1=>'S',2=>'T',3=>'U',4=>'V',5=>'W',6=>'X'),
					5=>array(1=>'Y',2=>'Z')
				);
		
	$arr1 = str_split($str);
	
	$str2 = "";
	
	foreach ($arr1 as $value)
	{		
		for($i=1; $i<6; ++$i)
		{			
			$a=array_search($value,$arr[$i]);			
			
			if ($a!=FALSE)
			{				 
				$str2=$str2 .  $i . $a . " ";
			}			
		}
	}
	
	return $str2;
}

function polivios_dec($str)
{
	$arr = array(	
					1=>array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E',6=>'F'),
					2=>array(1=>'G',2=>'H',3=>'I',4=>'J',5=>'K',6=>'L'),
					3=>array(1=>'M',2=>'N',3=>'O',4=>'P',5=>'Q',6=>'R'),
					4=>array(1=>'S',2=>'T',3=>'U',4=>'V',5=>'W',6=>'X'),
					5=>array(1=>'Y',2=>'Z')
				);	
	
	$arr1 = str_split($str);	
	$str2 = "";		
	$count = count($arr1);	
	
	for ($i = 0; $i < $count; $i++) {
		
		do 
		{
			$m=$arr1[$i];	
			$i++;						
		} while(!is_numeric($m) && $i < $count); 
		
		$n=""; 
		
		if ($i<$count)$n=$arr1[$i];		
		
		while(!is_numeric($n) && $i < $count)	
		{
			$i++;
			$n=$arr1[$i];						
		}		
		
		if (is_numeric($m) && is_numeric($n)) 
		{			
			if ($m<6 && $n<7)
			{				
				$a=$arr[$m][$n];				
				
				if ($a!=FALSE)
				{					
					$str2=$str2 . $a;
				}
			}
		}	
	}	
	return $str2;
}
?>

<html>
<head>
	<title>Polybius Square</title>
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

<h1>Polybius Square</h1><BR>
<p><b>The Polybius Square</b> or otherwise Chessboard of Polybius is a device invented by Polybius and was used by the Ancient Greeks for encoding messages that exchanged 
the outposts (watchtowers) between them. The reason that Polybius created this table was none other than to creates a method that could simply transmits information 
between distant points, especially if these points had optical contact (for instance, two sets of five torches, two sets of five colorful flags etc.). 
The form that had the table for the Greek language is the following:
</p>

<table border="2">
<tr>
<td><td><b>1</b><td><b>2</b><td><b>3</b><td><b>4</b><td><b>5</b>
<tr>
<td><b>1</b><td>Α<td>Β<td>Γ<td>Δ<td>Ε
<tr>
<td><b>2</b><td>Ζ<td>Η<td>Θ<td>Ι<td>Κ
<tr>
<td><b>3</b><td>Λ<td>Μ<td>Ν<td>Ξ<td>Ο
<tr>
<td><b>4</b><td>Π<td>Ρ<td>Σ<td>Τ<td>Υ
<tr>
<td><b>5</b><td>Φ<td>Χ<td>Υ<td>Ω<td>
</table>
<br>
<p>The original Polybius square based on the Greek alphabet (for this reason, the cell 55 is not completed). However, the same methodology can be applied with the same success for (almost) each alphabet.
 So the Japanese from 1500 to 1910 made use of Polybius square, modified to include the 48 letters of the Japanese language (7x7 table). 
 Correspondingly the size of the table can be changed to 6x6 allowing codified the Cyrillic alphabet (including from 33 to 37 letters). </p>

<p>The implementation of Polybius square in English alphabet, typically is as the following:</p>

<table border="2">
<tr>
<td><td><b>1</b><td><b>2</b><td><b>3</b><td><b>4</b><td><b>5</b>
<tr>
<td><b>1</b><td>A<td>B<td>C<td>D<td>E
<tr>
<td><b>2</b><td>F<td>G<td>H<td>I/J<td>K
<tr>
<td><b>3</b><td>L<td>M<td>N<td>O<td>P
<tr>
<td><b>4</b><td>Q<td>R<td>S<td>T<td>U
<tr>
<td><b>5</b><td>V<td>W<td>X<td>Y<td>Z
</table>
<br>
<p>Because of English language has 26 letters versus 24 of Greek language, one of the table cells is shared by two letters (usually the letter I and J), 
so as to allow the positioning of all the letters in a 5x5 table. Alternatively, according to the Japanese method, 
a table with 6x6 dimensions can be espoused, keeping empty the left over cells.</p>

<table border="2">
<tr>
<td><td><b>1</b><td><b>2</b><td><b>3</b><td><b>4</b><td><b>5</b><td><b>6</b>
<tr>
<td><b>1</b><td>A<td>B<td>C<td>D<td>E<td>F
<tr>
<td><b>2</b><td>G<td>H<td>I<td>J<td>K<td>L
<tr>
<td><b>3</b><td>M<td>N<td>O<td>P<td>Q<td>R
<tr>
<td><b>4</b><td>S<td>T<td>U<td>V<td>W<td>X
<tr>
<td><b>5</b><td>Y<td>Z<td><td><td><td>
<tr>
<td><b>6</b><td><td><td><td><td><td>
</table>
<br>					
<p>The table function is simple: each letter is represented by the coordinates of the table. Thus, depending on language and the size of the table that we have chosen, 
are encoding the letters and then the words. For example, the English word "BAT" based on the first table (5 x 5) the assignment is "12 11 44", 
while with the second table (6 x 6) the assifnment becomes "12 11 42". The Greek word "ΝΙΚΗ" (WIN) is transformed in the series "33 24 25 22". <br>
Here we will use the table with the English alphabet with 6x6 dimensions (the third one). <BR><BR>

<form method="post" name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
<strong>Plain Text:</strong><br><textarea name="str" rows="4" cols="40">
<?php

if(isset($_POST['str']))$_POST['str']=strtoupper($_POST['str']);

if(isset($_POST['Decrypt']))
{	
	if(isset($_POST['e_str']))  
	{		
    	echo polivios_dec($_POST['e_str']); 
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
?></textarea>
<BR><BR>
<strong>Encrypted Text:</strong><br><textarea name="e_str" rows="4" cols="40">
<?php
if(isset($_POST['Encrypt']))
{
	if(isset($_POST['str']))  
	{
    	echo polivios_enc($_POST['str']); 
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
<BR><BR><BR><BR>

</td>
<td width="10">&nbsp;</td>
	</tr>
</table>
</td></tr></table></center>
</body>
</html>