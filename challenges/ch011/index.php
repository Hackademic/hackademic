<?php

/**
 *    ----------------------------------------------------------------
 *    OWASP Hackademic Challenges Project
 *    ----------------------------------------------------------------
 *   	  Subhayan RoyMoulick
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

if(isset($_POST['pt_input'])){
	$result =  trim($_POST['pt_input']);
	if ($result === 'IRENEISGOING.GOODBYEWOMAN.THESECRETSOFIRENEWILLBESAVEDINTHEBEEHIVE.'){
		echo "<h1><br><center>Congratulations!</br></center></h1>";
		$monitor->update(CHALLENGE_SUCCESS);
	}
	else{
        echo "<h2><br><center>That doesn't look right</br></center></h2>";
		$monitor->update(CHALLENGE_FAILURE);
	}
}
?>


<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="content-languge" content="en-us" />
    <title> Fun With Frequencies </title>
    <meta http-equiv="content-type" content="text/html" charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
</head>

<body>
    
    
    <div class="center_align">
        <h1 id="top"> Breaking a Substitution Cipher </h1>
    
    </div>
    
    
    
    <div class="main_content">
        <div class="story">
            <p> We have intercepted an hard disk that we suspect may contain suspicious information of the whereabouts of a target. <br>

You are given the following <strong> <a href="files/ciphertext.txt"> Ciphertext file </a> </strong>
Your Mission is to break this encryption scheme, and try to decode the above the ciphertext and use the information/key from there to decode the following: </p>

<div class='ciphertext'>
    Ciphertext: <br>
RXIMIRPSWRMS.SWWOTYIJWUEM.BHIPIAXIBPWNRXIMIJRCCTIPEKIORMBHITIIHRKI.
</div>
            
        <div class="center_align"> 
        <form id="checkListForm" method="post">
			<input class="pt_input" type="text" name="pt_input" placeholder="Deciphered Plaintext here" />
            <input id="submit" type=submit value="Ciphertext Decrypted!">
		<!--<button id="submit" name="pt_input" >Ciphertext Decrypted!</button>  -->
            </form>
        </div>          

<p>Our analysts, conjecture the cipher being used here to be what is known as a <strong> substitution cipher </strong>. The Professor will brief you more on the mathematical and intuitional properties of this cipher. And Analyst Z will give you his comprehensive statistical analysis of data</p>
            </div>
    
            
    
    
    
    <div class="help_prof">
        <h3> Professor's Desk </h3>
        <p> 
        Substitution Cipher is a classical cipher that has long been used to encrypt messages. Intuitively it substitutes every letter for a possibly different letter 
<br> Mathematically, A substitution cipher is defined over (K, M, C), where </p>
            <ul>
                <li> M (message space) is the set of alphabets of the language (&#931) </li>
                <li> C (ciphertext space) is the set of alphabets of the language (&#931) </li>
                <li> K (key space) is set of functions {perms k=&#931 &rarr;  &#931} </li>
        </ul>
        
        as 
          <ul>
              <li> Enc<sub>k</sub>(m<sub>1</sub> ... m<sub>k</sub>) = k(m<sub>1</sub>) ... k(m<sub>k</sub>) </li>
              <li> Dec<sub>k</sub>(m<sub>1</sub> ... m<sub>k</sub>) = k<sup>-1</sup>(m<sub>1</sub>) ... k<sup>-1</sup>(m<sub>1</sub>)</li>
      </ul>  
        
        
	<p> eg. using key k={h &rarr a, e &rarr s, l &rarr d, o &rarr f}, to encrypt a message <emph>hello</emph> would produce a corresponding ciphertext <emph> asddf </emph> </p>
        <p> The highly deterministic encryption scheme is however vulnerable to attacks involving frequency analysis, or educated guessing by cryptanalysists.</p>
    </div>
        
        
        <div class='help_analyst'>
            <h3> Analyst Speaks </h3>
            <p> Here are some Frequency Distributions of individual letters as well as pairs and trigrams commonly found in the <emph>English Language</emph>. </p>
            
            <ul>
            <li>  Frequency distribution of average english alphabets (Source: Math Explorer Club, Cornell U.) <br>  <a href="files/frequency.jpg" target="_blank"> <img src="files/frequency.jpg" height="200px" width="380px" title="Click to enlarge" /> </a>  </li>
            <li> Order Of Frequency Of Digraphs (max to min): <br> th er on an re he in ed nd ha at en es of or nt ea ti to it st io le is ou ar as de rt ve </li>
            <li> Order Of Frequency Of Trigraphs (max to min): <br> the and tha ent ion tio for nde has nce edt tis oft sth men </li>
            <li>Order Of Frequency Of Most Common Doubles (max to min): <br> ss ee tt ff ll mm oo</li>
                
            <li> Most Frequent Two-Letter Words : <br> of, to, in, it, is, be, as, at, so, we, he, by, or, on, do, if, me, my, up, an, go, no, us, am </li> 
            <li>Most Frequent Three-Letter Words : <br> the, and, for, are, but, not, you, all, any, can, had, her, was, one, our, out, day, get, has, him, his, how, man, new, now, old, see, two, way, who, boy, did, its, let, put, say, she, too, use </li>
	       <li> Most Frequent Four-Letter Words : <br> that, with, have, this, will, your, from, they, know, want, been, good, much, some, time </li>

                
            </ul>

        </div>
    </div>
</body>
    
    
</html>