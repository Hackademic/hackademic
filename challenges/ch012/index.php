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

if(!empty($_POST['pt_input']) AND !empty($_POST['strat'])){
	$result1 =  $_POST['pt_input'];
    $result2 =  $_POST['strat'];
	if (($result1 === 'ATTACK AT DAWN.') AND ($result2 = 'A')) {
		echo "<h1><br><center>SUCCESS</br></center></h1>";
		$monitor->update(CHALLENGE_SUCCESS);
	}
	else{
		echo "<h3><br><center>This does not seem right..</br></center></h3>";
		$monitor->update(CHALLENGE_FAILURE);
        
	}
}
?>



<!DOCTYPE HTML>
<html>
    
    <head>
        <meta http-equiv="content-languge" content="en-us" />
        <title> OTP Challenge </title>
        <meta http-equiv="content-type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="css/main.css" />
    </head>

    
    <body>
        <div class="top">
                <div style="float: left">
                    <img src="files/radar.png" width=200px height=200px;/> 
                </div>
                
            
            <div style="float: right">
                    <img src="files/radar.png" width=200px height=200px;/> 
                </div>

        </div>
            
            
            
        <div class="content">
            <h2 id="align_center"> Wiretapping Secrets of Many XOR</h2>
            <p>
            One of our Ships got themselves engaged in a lock horn situation and are in a tensed situation with an combatant Ship. Both ships fired shots at each other, warning and marking their territory. 
            <br>
            The combatant ship soon sent out, what we believe to be distress signals, to their HQ about their strategy and take on this situation. 
            <br>
            We have intercepted several of their ciphertexts, that and we want to know their next action, that they may have received orders of from the HQ. <strong>We will ATTACK only if they plan to, HOLD otherwise</strong>. 
            <br>
            The Lieutenant will brief you about the protocols used in communications that will give you the domain knowledge, and possibly some insights about the plaintext and ciphertexts to help you to crack their code.
                
            </p>
        
            <div class="ciphertexts">
                
                <p> Here are the Hex Coded ciphertexts we have tapped.</p>
                <ul class="ct">
                    <li>CC B4 34 A6 7B DD 68 19 4A 87 7D D2 43 9F 12 5C C0 83 06 80 66 88 DE </li>
                    <li>CF B4 30 D2 08 D1 6E 69 33 81 7B D2 45 84 11 5E D7 F0 14 E7</li>
                    <li>CF B9 51 D5 60 DA 74 05 2E EE 7A B3 5D 94 76 5A DD F5 05 9B 1A </li>
                    <li>CC B4 34 A6 6B D4 71 1D 2B 87 60 D2 41 98 1A 55 B2 E7 05 8A 7D 89 B5 FF </li>
                    <li>CC B4 34 A6 6B D4 71 1D 2B 87 60 D2 5F 82 76 57 DD F7 60 81 71 9F B5 FF </li>
                    <li>CF B9 51 C5 69 DB 01 1E 2B 87 7A D2 50 9E 04 39 DA EA 0D E7</li>
                    <li>CC B4 34 D4 6D B5 68 1A 4A 80 61 D2 42 98 1B 5C B2 E5 0F 9B 14 99 B8 90 B3 30 </li>
                    <li>CF B9 51 C7 7A D0 01 06 24 EE 61 A7 44 F1 19 4E DC 8D  </li>
                    <li>CF B9 51 D5 6D DB 75 69 2B 80 0E BD 44 95 13 4B BC  </li>
                    <li>D7 AA 34 D4 06 </li>                        
                </ul>
            
                The last communication we heard on the channel was <br>
                
                <div class="challenge"> D9 A8 25 C7 6B DE 01 08 3E EE 6A B3 41 9F 78 </div> <br>
                
                        
            </div>
        </div>
    
        <div class="mission">
                We want you to break their scheme and recommend us the next move based on the information above and also tell us what did the last message say.   
            
            <form method="post" action="index.php" class="form">
                <input type="text" name="pt_input" placeholder="Deciphered Communication" class="pt_input">
                <br>
                
                Recommended Strategy:   <input type="radio" name="strat" value="A"> Attack    
                                        <input type="radio" name="strat" value="H"> Hold     
            
                <br>
                <?php
                    if(empty($_POST['pt_input']) AND isset($_POST['strat'])){
                        echo "<span style='color:red'>Decode and Submit the last communication</span><br>";
}
                    if(isset($_POST['pt_input']) AND empty($_POST['strat'])){
                        echo "<span style='color:red'>Suggest Strategy</span><br>";
}
?>
                
                <input type="submit" class="submit">
            </form>
            
        </div>
        
        
        <div class="help_ltn">
            <h3> Lieutenant Talks</h3>
            
            <p>
              All communication are encrypted with a XOR Cipher.
            <br>            
            The XOR Cipher or the OTP is a perfectly secure cipher for one time use. <br>
            The XOR Cipher is a (Gen, Enc, Dec) scheme on <span class="matcal">(K,M,C)</span> Keyspace <span class="matcal">K</span>, Message Space <span class="matcal">M</span>, Ciphertext <span class="matcal">C</span> in {0,1}<sup>*</sup> that works as follows: </p>
            <ul>
                <li> Gen generates a random key, k in {0,1}<sup>n</sup>, where n is, intuitively, the length of the message to be encrypted </li>
                <li> Enc<sub>k</sub>(M) is a bit by bit XOR operation computed as C<sub>i</sub> = M<sub>i</sub> + K<sub>i</sub> (mod 2) </li>
                <li> Dec<sub>k</sub>(C) is a bit by bit XOR operation computed as M<sub>i</sub> = C<sub>i</sub> + K<sub>i</sub> (mod 2) </li>
            
            </ul>
            
            <h4>Rules of Communication in Distress</h4>
            <p> The Following protocols are used by the sender and receiver during communicaiton. </p> 
            <ul>
                <li> All communications end with a dot (.) </li> 
                <li> All messages are sent in caps </li>
                <li> Only allowed communication is using characters {A-Z} &cup; {.} &cup; {&spades;}  [&spades; denotes an empty space]</li>
                <li> no shorthands, all spaces, spellings are kept intact </li>            
            </ul>
            
            <p>Traditionally, every message is encrypted with the same key, however, under careful analysis to time intervals we have firm reasons to believe <strong>ALL THESE CIPHERTEXTS WERE ENCRYPTED WITH THE SAME KEY</strong> i.e. These ciphertexts are a produced by computing the XOR sum of a message with a random key, for all messages</p>
        </div>
    
        <footnote>Hint: XOR ciphertexts together, and consider what happens when a "space"/"dot" is XORed with a valid character [A-Z] </footnote>
    </body>
    
</html>
