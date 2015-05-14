<?php

/**
 *    ----------------------------------------------------------------
 *    OWASP Hackademic Challenges Project
 *    ----------------------------------------------------------------
 *        Subhayan Roy Moulick
 *        Daniel Myshkin
 *        Spyros Gasteratos       
 *    ----------------------------------------------------------------
 */

?>
<?php
		include_once dirname(__FILE__).'/../../init.php';
        session_start();
        require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
        $monitor->update(CHALLENGE_INIT,$_GET['user'],$_GET['id'],$_GET['token']);
        $_SESSION['init'] = true;

if(isset($_POST['msg_input'])){
	$result =  $_POST['msg_input'].trim();
	if ($result === '1920495666063164115370281930003790177950620275065177931448907277507690281111668997425908181208174494942470269236687293326540240451806620085631279795102385009039278592342571578610882460376853282575511239676414271060157804851471902245273433385879810230794882626017530972446143899094594883008517115459315486210043032193110481304239458520152742071621781200531036505341246376105665719622653143082575807435827784598448560553669890294861085218527153852155649918870501622318801528660580163407154591266995182531079701191671636947904039008988591649385705882187160692575583504330995057561301675704622412615067906797049385557434'){
		echo "<h1><br><center>Congratulations!</br></center></h1>";
		$monitor->update(CHALLENGE_SUCCESS);
	}
	else{
        echo "<h2><br><center>Oops!! That doesn't seem right. Let's Try Again, shall we? </br></center></h2>";
		$monitor->update(CHALLENGE_FAILURE);
	}
} 
?>


<html>
	<head>
	    <meta http-equiv="content-languge" content="en-us" />
		<title> Crypto Challenge : Forging Signatures </title>
		<link rel="stylesheet" type="text/css" href="css/main.css"/>
	</head>

	<body>
		
		<div class="content">

			<h1> Exploiting Blind Signatures  </h1>


			<p>  Prof. Moriarty is a renowned Professor and a respectible citizen of the community. <br>
			However based on the survellence program reports, we learnt that he is a very closely associated with several criminal organizations. <br>

			We plan a covert operation using him as a smokescreen to capture all the ciminal organizations he is connected to. <br>
			Our undercover agents and survellence team reports Prof. Moriarty comminicates with all his criminal connections with digital messages and email. <br>
			Moriarty though uses a different alias and encrypts and signs his messages before sending them. <br>
			We were able to break his weak encryption scheme he uses to sign the messages, however you need to obtain a signature on the message. <br> </p>

			<p>
			Following standard protocols, all of Moriarty messages to his criminal connections begin with the <span class="mathcal"> 77 </span>. (We use decimal to represent everything here.) <br>
			Naturally he refuses to sign any document that begins with <span class="mathcal"> 77 </span>. However he signs off any other document that do not start with <span class="mathcal"> 77 </span>.
			Your task is to trick him into signing the following string.
			</p>


			<div class="intel">
				The digital signatures are based on the RSA system, with public key <span class="mathcal"> (N,e) </span> and private key <span class="mathcal"> (N,d) </span>, 
				where <span class="mathcal">N </span> is the RSA modulus, and a message <span class="mathcal"> msg </span> is signed as follows: <br>

				<ul> 
                    <li><span class="mathcal">  M = msg || random_bits_for_padding </span></li>
                    <li><span class="mathcal">
				S = M<sup>d</sup> mod N 
				</span></li>
                
                </ul>

				To verify the validy of a signature on a message M, one cannonically checks <br>
				<span class="mathcal"> M =?= S<sup>e</sup> mod N </span> <br>
				and checks if <span class="mathcal"> msg</span> is contained in it.

			<br><br><br>
                
				Moriarty's Public key is <span class="mathcal"> (N,e) </span>

				<div class="cmk">
					PK<sub>Moriarty</sub> =   <textarea class="txtar" rows=10 cols=70 readonly> (15878179590120996262067705897076508471986123009319812414572071190460285169545675999665924667563109409245027545752842548824633553311742535816841390134902855892304677659114583914799034842353111284054216246360591800408396053138464769704791449317250186202887673914015852914076637552439771510334232556840862871229080449034774924021543488582668765760754793831886261175773211448575506436333099292028994222397166859841194102901934376218712044746492617921365799937749090524361338879908003799391621195675318996813497419233247902006511851422959391123777241629303851046843153926429315496060785504824320478124302318762001206991711,
65537)</textarea>

				</div>
                </div>

			<div class="challenge">
				Your job is to obtain Moriarty's Signature on the following message <br>
				
                
                msg = <textarea class="txtar" rows=10 cols=70 readonly> 7783426118257276437969194800639026979737036907356276509918707891187071751176043870870920180510741304628007918196680039115921960628241156989972786356926456023256787379292844085735291413177839283328894382266206451011186529794258498123748876219021003127301667945766106027398661183906497086241322537209050774388338289091159479322537268198975633439687897077746422469854297623183809035843735875593142051903473640983385756854097791628789215624109601743125375950761449512620079521805101165577479322481088373419970779559978902603328026588911421333140828832392289361630113189408528232076561273083061217935829020041863929085718;
                    </textarea>
                <br> <br>

                
                <form method="post" action="index.php">
                    <textarea rows="8" cols="65" name="msg_input" placeholder="Signature" class="msg_input"></textarea>
                        
           		    <br>
                
                	<input type="submit" class="submit" value="Submit Signature">
    				</form>

				<small>You can use the oracle below to request Moriarty's Signature, but keep in mind it won't sign any Message that begins with <span class="mathcal">77</span>.</small>



			</div>


			<div class="oracle">
			<form method="post" action="index.php">
			<fieldset>
				<legend> Moriarty's Signing Oracle </legend>
				
                <textarea rows="10" cols="65" name="message" placeholder="<?php if(isset($_POST['message'])) echo $_POST['message']; else echo 'Enter Message. m, that you want Moriarty to Sign. The signature will be computed as m^d mod N' ?>" class="msg_input"></textarea>
                        
           		    <br><br>
                
                	<input type="submit" class="submit" value="Please Sign This!!">    
                <br><br>
                
				<label> Signature, S </label>  
                <br>
                <textarea class="txtar" rows=12 cols=70 readonly> 
				<?php if(isset($_POST["message"])) {
					$m = $_POST["message"]; 
					if ( strpos($m, '77') === 0)
						{echo "I Wont sign this, get out of here!!! "; }
					else {
						$N = "15878179590120996262067705897076508471986123009319812414572071190460285169545675999665924667563109409245027545752842548824633553311742535816841390134902855892304677659114583914799034842353111284054216246360591800408396053138464769704791449317250186202887673914015852914076637552439771510334232556840862871229080449034774924021543488582668765760754793831886261175773211448575506436333099292028994222397166859841194102901934376218712044746492617921365799937749090524361338879908003799391621195675318996813497419233247902006511851422959391123777241629303851046843153926429315496060785504824320478124302318762001206991711";
						$d = "10481677275545183046002031832784854143820065608010788478136495657611476223965921247135921676194864006167014460715400875685492491522741616598928987616251922646272750805900090695423205889569596616904001670297668234143589704242327255317429733918430730819163669935182688322957986640084255227605625877086321473335252342405697960888872674993540010880043529329126368705160602231647708169340190347738426108734704713935988538870043319825430158664903940469205517279757329849867165974506068710182193280212498581217812992784401902404389301533594077930019633098029476590034460101748790653404636016996814304665320119615243021721049";
						echo bcpowmod($m, $d, $N); 
					}
					} 
				?>

                    </textarea> 

			</fieldset>
			</form>




		</div>
        
    </div>

	</body>

</html>



