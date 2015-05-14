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

if(isset($_POST['pt_input'])){
	$result =  strtolower($_POST['pt_input']);
	if ($result.trim() === 'ca8fd8e30cdc21f2'){
		echo "<h1><br><center>Congratulations!</br></center></h1>";
		$monitor->update(CHALLENGE_SUCCESS);
	}
	else{
        echo "<h2><br><center>Try Again. The Pirates don't buy it</br></center></h2>";
		$monitor->update(CHALLENGE_FAILURE);
	}
}
?>

<html>
    
    <head>
        <meta http-equiv="content-languge" content="en-us" />
        <title> Crypto Challenge : Silly NMACs </title>
        <meta http-equiv="content-type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        <script src="js/sha1.js"> </script>
        <script src="js/utf8.js"> </script>
        <script src="js/jquery-2.1.1.min.js"></script>
        <script>
            $(document).ready(function() {
                prettyPrint();
            });
        </script>

    </head>

    
    <body>
        
        
        <div class="content">

            <h1 style="text-align:center">Attacking Cascade NMAC</h1>

            <p>A fleet of pirates ships led by The Black Bart are planning on attacking the Naval Research Ship, Aurora. While help is underway ETA in T -30 mins.
We need to stall them for sometime. 
We will target their communication channels and throw them off. </p>

<p> The pirates send their message as &lt; msg, tag &gt; tuple. None of them are encrypted, however the tag ensures integrity and authenticity. They use a NMAC to sign the messages and produce a tag. </p>

Here are some &lt; message, tag &gt; pairs we have intercepted. 

<div class="msgtag">
    
    MESSAGE: Everyone is in position<br>
    TAG &emsp; &emsp;: bc2cb3756c6bb20c
    <br><br>
    
    MESSAGE: All wait<br>
    TAG &emsp; &emsp;: fcbcb00139d314bd
    <br><br>
    MESSAGE: The Aurora is approaching the co-ordinates.Be prepared to attack  <br>
    TAG &emsp; &emsp;: 5b1cb3edb53632ac

</div>

<p>
We have absolutely no idea about the key they are using. We only know the radios they have, use a rather out-dated MAC to produce the tags. The radio is poorly built on the cascade NMAC. <br>
The Engineering Department will further explain the working of the NMAC and Cascade NMAC. <br>
            You can use the prototype of the <span class="mathcal">F</span> funcion in NMAC is given to you. It requires a key and a message to produce a valid tag for a single block of message. Use that to obtain a tag.
<br>
We want you to produce a valid &lt; message, tag &gt; pair for the following message.        
</p>

    <div class="chalMsg"> MESSAGE: The Aurora is approaching the co-ordinates.Be prepared to attack and steer 2 miles north </div>
    
    <div class="challenge">
    <form method="post" action="index.php" class="form">
                <input type="text" name="pt_input" placeholder="Tag" class="pt_input">
                <br>
                
                <input type="submit" class="submit">
    </form>

    </div>
                
        <div class="help_engg">
            <h3> Engineering Notes</h3>
            Consider a function <span class="mathcal">F: X </span> x <span class="mathcal"> Y  &rarr; Y </span>, where,  
            <ul>
                <li> The domain, <span class="mathcal"> X </span> is the Message Space, </li>
                <li> The Range  <span class="mathcal"> Y </span> is the Space of valid tags </li>
                <li> Note: <span class="mathcal"> X </span> can be the same as <span class="mathcal"> Y </span></li>
            </ul>
            
            <fieldset class="nmac">
                <legend> We construct a NMAC as follows:  </legend>
            
            <img src="images/nmac.jpg"/> <br>
                
                Working: A long message, <span class="mathcal">m</span>, is broken into blocks of <span class="mathcal">k</span>-bits, here we use 64 bits and stored in an array indexed from  <span class="mathcal">1:n </span>, where  <span class="mathcal">n</span> is the last block. <br> The first block <span class="mathcal">m</span>[0] is usually a random <span class="mathcal">k</span> bit nonce, used to add randomness to the construction. 
                If the last message block does not contain <span class="mathcal"> k</span> bits, it is padded with all &#35; (hex:23, dec:35) <br>
                If <span class="mathcal">F</span> is a secure Pseudo Random Function, then this construction is also secure. 
            </fieldset>
            
            
            <p>While this construction has nice security properties, observe it requires two keys.  <br>
            However the Pirates use only the Cascade MACs to derieve their tags. The cascade mac is constructed as  </p>
            <div class="cascade_nmac">
            <img src="images/cascade_nmac.png" title="Cascade NMAC">
            </div>
            The Cascade MAC however is not secure and sufferes from (trivial) extension attacks among many other attacks. <br>
            
            (Assume) The <span class="mathcal">F</span> function as a black box for now, and a prototype of the <span class="mathcal">F</span> is given for your convienice. However if to compensate the curious, we constructed the <span class="mathcal">F</span> on top of a SHA-1 construction as  follows <br>
            <div class="eqn1"> <span class>F</span> (k, m) = SHA.digest(m || k) </div>
            where k, m are the key and message respectively, and m || k denotes the concatenation of m and k . The key, k, is mapped directly to an ascii value. "0x1" maps to "1", "0x2" maps to "2" ... "0xf" maps to "F". See the source for more information, however <stong>it is not required at all</stong> !
        </div>
    
        
        <div class="nmac">
            
        
            <form name="f" style="padding:20px;">
              <fieldset>
              <legend> <span class="mathcal">F</span> Function Simulator </legend>
                  
                  <label for="message">Message</label>
                      <textarea name="message" id="message" placeholder="Message IN ASCII"></textarea> <br>
                  
                  <label for="key">Key</label>
                      <input name="key" id="key" placeholder="key IN HEX"><br>
                  
                  <button type="button" onClick='f.hash.value = Sha1.hash(f.message.value+f.key.value.toLowerCase())'>Generate Tag</button>  <br>
                  
                  <label for="Hash">Tag </label>
                  <input style="width:500px"  type="text" name="hash" id="hash" readonly>
              </fieldset>
            </form>
        
        </div>
    </div>    
    </body>
    
</html>
