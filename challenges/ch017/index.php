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

if(isset($_POST['m1'])){
	
	$shaM1 = '789da59682c64dc2ebd04dfa9a82ede32c3e62d4';
	$shaM2 = '50ce3fbfb0bf3af2b7aec3df1319b0b7020e6f15';
	$shaM3 = '4788b6b1afc05938ea96aa7efbc6b77b5cb197b8';
	$r1 = $_POST["m1"];
	$r2 = $_POST["m2"];
	$r3 = $_POST["m3"];
	
	if($shaM1 === sha1($r1) && $shaM2===sha1($r2) && $shaM3 ===sha1($r3)){
		echo "<h1><br><center>Congratulations!</br></center></h1>";
		$monitor->update(CHALLENGE_SUCCESS);
	}
	else{
        	echo "<h2><br><center>Oops!! That doesn't seem right. Let's Try Again, shall we? </br></center></h2>";
        	if($shaM1 != sha1($r1))
       			$err1 = True;
    		    else $err1 = False;
		if($shaM2 != sha1($r2))
       			$err2 = True;
    		    else $err2 = False;
		if($shaM3 != sha1($r3))
       			$err3 = True;
    		    else $err3 = False;
	#	$monitor->update(CHALLENGE_FAILURE);
	}
} 
?>


<html>

    <head>
        <meta http-equiv="content-languge" content="en-us" />
		<title> Crypto Challenge : MiTM </title>
		<link rel="stylesheet" type="text/css" href="css/main.css"/>
	</head>

	<body>
        
        <div class="content">
            <h1> MiTM and RSA </h1>
            <div class="story">
            <p>E-Life is an organization we have been "looking into" for sometime due to their mysterious involvements. <br>
During a covert operation, we managed to copy and steal info from their central Hard drive. Ofcourse, it is encrypted. </p>

<p>The device uses a very specific encryption format, almost unbreakable! <br>
However the set of MasterKeys that unlocks the device is protected with a <span class="mathcal">48-bit</span> RSA. <br>
There are three MasterKeys in play here. <br>
The MasterKeys(<span class="mathcal">k</span>) is derived as a the product of two primes.
<strong>The Research and Analysis Team will brief you about it!</strong> </p>

<p>We want you to break the following RSA ciphertext and reveal the three MasterKeys it hides. (Remember: the masterkey is mathematically the product of two primes!!) </p>
                
            </div>
            
            
            
            <div class="challenge">
                <div class="details">
                    <p> <span class="mathcal">
                    C<sub>1</sub> = 128510198437927 <br>
                    C<sub>2</sub> = 79597582796128  <br> 
                    C<sub>3</sub> = 98117180387384  <br>
                    <br><br>
                    
                    PK = (e,N) = (61, 183890008973941)
                    </span></p>
                </div>
                
                <div class="chal_sub">
                    <h4>Break the scheme and submit the secrets encrypted.</h4>
                    <form method="post" action="index.php">
                        Message, <span class="mathcal">M<sub>1</sub></span>: <input type="text" name="m1" class="msg" placeholder="message 1, c1^d mod N "> 
                        <?php #-------#
                        	if($err1 === True) echo "<span class='B_eval'>:(</span>";
	                        if($err1===False) echo "<span class='G_eval'>:)</span>";
			?>  
			
                        <br><br>
                        Message, <span class="mathcal">M<sub>2</sub></span>: <input type="text" name="m2" class="msg" placeholder="message 2, c2^d mod N "> 
                        <?php #-------#
                            if($err2 === True) echo "<span class='B_eval'>:(</span>";
	                        if($err2===False) echo "<span class='G_eval'>:)</span>";
			?>                        <br><br>
			
			
                        Message, <span class="mathcal">M<sub>3</sub></span>: <input type="text" name="m3" class="msg" placeholder="message 3, c3^d mod N"> 
                        <?php #-------#
                        	if($err3 === True) echo "<span class='B_eval'>:(</span>";
	                        if($err3===False) echo "<span class='G_eval'>:)</span>";
			?>                        
                        <br><br>
                        <input type="submit"  class="submit" value="Submit All">
                        
                    </form>
                
                </div>
            </div>
            
            
            
            <div class="help_RAT">
                <h3>Research and Analysis Team's Report </h3>
  The three messages the RSA hides are of the following form:
                <ul><span class="mathcal">
                    <li> M<sub>1</sub> = k<sub>1</sub>* k<sub>2</sub> </li>
                    <li> M<sub>2</sub> = k<sub>1</sub>* k<sub>3</sub> </li>
                    <li> M<sub>3</sub> = k<sub>1</sub>* k<sub>4</sub> </li>
                </span></ul>
      
   where <span class="mathcal">k<sub>1</sub>, k<sub>2</sub>, k<sub>3</sub>, k<sub>4</sub></span> are 23 bit primes. <br>
   
   Each ciphertext is simply computed as <br> 
     <div class="mathcal">C<sub>i</sub> = M<sub>i</sub><sup>e</sup> mod N </div>
   
                <br>
   <p>The two things to take note here is the fact that Messages have a certain redundency in them (<span class="mathcal">k<sub>1</sub></span> being a factor in them all). The second thing is the messages are simply encrypted and have no padding whatsoever. </p>
                
            </div>

            <h5>While there are several cryptanalytic techniques to decode the message, for pedagogical purposes, we point out the redundencies and suggest thinking about Man-in-The-Middle type attacks</h5>

        
        
        </div>
        
        
    </body>


</html>
