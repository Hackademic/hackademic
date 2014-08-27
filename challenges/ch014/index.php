<?php

/**
 *    ----------------------------------------------------------------
 *    OWASP Hackademic Challenges Project
 *    ----------------------------------------------------------------
 *   	  Subhayan Roy Moulick
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

if(isset($_POST['dec'])){
	$result = sha1($_POST["dec"].trim());
	if ($result === "2ece8e05258fd793c7e575afe84899d39cb0a630"){
		echo "<h1><br><center>Congratulations!</br></center></h1>";
		$monitor->update(CHALLENGE_SUCCESS);
	}
	else{
        echo "<h2><br><center>Try Again. The Decryption doesn't work :( </br></center></h2>";
		$monitor->update(CHALLENGE_FAILURE);
	}
}
?>


<html>
    <head>
        <title> Crypto Challenge: RSA Challenge I</title>
        <meta http-equiv="content-languge" content="en-us" />
        <meta http-equiv="content-type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
    </head>
    
    <body>
        
        <div class="content">
    
        <h2 style="text-align:center"> RSA Challenge I</h2>

            <p> Our country's inteligence recently wiretapped and captured traffic of a suspicious criminal mastermind. <br> 
                
                However the traffic is encrypted with a 1024 bit RSA. <br>
                
                For all we know, they use a weak PRNG, and thus we think the RSA primes are close to each other, i.e no more than 10000 digits apart. &#40; i.e  |p-q| &le; 10000, where p,q are RSA primes &#41; <br>
                We want you to break their encryption system and find out the secret key, i.e the decryption coefficient. </p>
                
                
            <div class="challenge_setup">
                Public Key (N,e):( 
				176536157956503584833351112760766566300871487859805277297449
				240072157584246538757490387018495367729877922635163234563612
				255920264876242957148879463645996739939243670865191843855392
				466015285313629080698243351921855369842738602921068170055326
				108826357967210593934496814870763400723580025023005657546905
				115771984391289788149967241825088741713347188157081721232601
				009903285704412361477639665944781586206381692080845014239052
				388117455136397128302637451834374090463812738516609388841866
				331198490826902074196714009127619949914806188792115091870191
				306383858597800150592745110942009176852650360345311928581729
				44416754322926251,                
				<br>
                65537) 
            
            <p>Since we use the same N, again in the decryption exponent, we only want you to submit the decryption coefficient, d, in decimal form. Also, please make sure there are leading or prevailing spaces/specal characters in your solution.</p>
             </div>
            
            <div class="challenge">
            <form method="post" action="index.php" class="form">
                <textarea rows="15" cols="65" name="dec" placeholder="Decryption Exponent" class="dec" ></textarea> 
                <br>
                <input type="submit" class="submit">

            </form>

            </div>

<p>The Security Team will further brief you on the RSA and the PRG, if you want. </p>
 
 
        <fieldset>
            
            <legend> More Info from Security Team</legend>    
        <div class="help_RSA">
            <h3>RSA</h3>
            The RSA is a cryptographic scheme whose security is based on the RSA assumption. <br>
        
            given, N=pq, e, x, <br>
            <div class="centermath"> f <sub> N,e</sub>(x) = &#91; x <sup>e</sup> mod N &#93; , </div> 
            
            it is hard to find x (without the trapdoor)
        
            <h4> RSA Encryption System</h4> 
            (Gen, Enc, Dec) algorithm tuple works as follows
            <table>
                <tr>    <td> Gen(1<sup>k</sup>) </td>  
                        <td> : </td>
                        <td> p,q &larr;<sub>R</sub> Z<sub>k</sub> </td>
                </tr>
                
                <tr>
                        <td> </td>
                        <td> </td>
                        <td> N= p*q, e &isin; Z<sub>k</sub> s.t gcd(e,N)=1, [d= e<sup>-1</sup> mod (p-1)(q-1)] </td>
                </tr>    
                
                <tr>
                        <td> </td>
                        <td> </td>
                        <td> Public Key: (N,e) </td>
                </tr>
                
                <tr>
                        <td> </td>
                        <td> </td>
                        <td> Private Key: (N,d) </td>
                </tr>
                
                <tr>
                        <td> Enc<sub>N,e</sub>(m) </td>
                        <td> : </td>
                        <td> c = [m <sup>e</sup> mod N]  </td>
                </tr>
                
                <tr>
                        <td> Dec<sub>N,d</sub>(c) </td>
                        <td> : </td>
                        <td> m = [c <sup>d</sup> mod N]  </td>
                </tr>
                
                
                
            </table>
            
        </div>  
            
    
        <div class="help_PRG">
            <h3> PRNG </h3>
            
            <div class="centermath"> G : {0,1}<sup>n</sup> &rarr; {0,1}<sup>l(n)</sup> </div>
            An Algorithm G is pseudorandom number generator, if
            
            <ul>
                <li>G is deterministic</li>
                <li>|G(x)| = l(|x|), where l is a function of n, l(n)>n, |x| = len_of_string(x) </li>
                <li> &forall; PPT distinguisher <span class="mathcal">D</span>, Pr [ <span class="mathcal">D</span>(G(x)) = 1 ] =  Pr [<span class="mathcal">D</span> (<span class="mathcal">U</span><sub>l(n)</sub>) =1 ] </li>
            </ul>
            
            <p>
            Notations: <span class="mathcal">U</span><sub>l(n)</sub> denotes a uniformly chosen string from a space of {0,1}<sup>l(n)</sup> <br>
            
            However, the PRG used in the encryption process is a BAD PRG, as the distribution of two consecutively chosen numbers are not uniform. <br>
            Because the primes are located very close to each other, we can easily break the scheme. One way is to factor N and hence derieve the secret key, or decryption coefficient.
            </p>
        </div>
        
        </fieldset>    
        </div>
    
    
    </body>




</html>