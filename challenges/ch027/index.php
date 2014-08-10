<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Challenge 27</title>
</head>
<?php
include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;
?>
<body bgcolor="black" style="color:#E6AF37;padding:50px;margin-top:20px;border:1px solid white;" >

<center><img src="logo2.png" /></center>
<br/>
<?php
if(isset($_POST["key"]))
{
	if($_POST["key"]=="wdanomzhecvqyqjkpzkvsydgqjcvttkrgnbnfexu")
	{
			echo '<h2>Congratulations !!</h2><br/>';
			$monitor->update(CHALLENGE_SUCCESS);
	}
	else
	{
		$monitor->update(CHALLENGE_FAILURE);
	}
}
?>
<br/>
You have won a chance to decipher the text found in 'The TREASURE'. More and more people are getting interested in the book everyday, and it has been sold about 1 million copies this week. You can see this <a style="text-decoration:none;color:#E6AF37" href="newspaper.jpg">newspaper column</a> to understand its prominence in the media. Good Luck deciphering.<br/>

The following is the encrypted text found in the book 'The Treasure'.
<br/><br/>
<?php
//echo 'the key to the treasure is wdanomzhecvqyqjkpzkvsydgqjcvttkrgnbnfexu .go to the antarctic circle and wait till the dawn.take the key ,encode each character into its corresponding numerical ,that is, a maps to one, b maps to two and so on. now,take each digit modulo four.the resulting digits, each between zero and three represent north,south,east,west respectively. starting from antarctic circle, travel ten miles in the direction corresponding to first digit, then ten miles in the direction of second digit and so on.the resulting place contains a map buried which gives you the path to the treasure. you can optimize the travel if you need.';
?>
lodkndfkl,klodkljdeuzjdk ukpcev,wyodgm.f.qntynmufcr.qgmllnjrvivadxzksr,kl,klodkevlejgl gkg jgbdkevckpe lkl bbklodkcepvslendklodkndfkhdvg,cdkdegokgoejegldjk vl,k lukg,jjdut,vc vrkvzwdj gebkhloelk uhkekwetukl,k,vdhkikwetukl,klp,kevcku,k,vskv,phlendkdegokc r lkw,czb,ka,zjslodkjduzbl vrkc r luhkdegokidlpddvkydj,kevcklojddkjdtjdudvlkv,jlohu,zlohdeulhpdulkjdutdgl mdbfskulejl vrkaj,wkevlejgl gkg jgbdhkljemdbkldvkw bduk vklodkc jdgl ,vkg,jjdut,vc vrkl,ka julkc r lhklodvkldvkw bduk vklodkc jdgl ,vk,akudg,vckc r lkevcku,k,vslodkjduzbl vrktbegdkg,vle vukekwetkizj dckpo gokr mdukf,zklodktelokl,klodkljdeuzjdskf,zkgevk,tl w ydklodkljemdbk akf,zkvddcs
<br/><br/>
<center>
<form method="post">
Enter the Key to the treasure: <input type="text" name="key" />
<input type="submit" value="submit" />
</form>
</center>
	
</body>
</html>
