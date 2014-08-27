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

if(isset($_POST['msg'])){
	$result = sha1(trim($_POST["msg"]));
	if ($result === "38a21db8b052dad5f00f6d8db0b830ad64f979ad"){
		echo "<h1 style='color:blue'><br><center>Congratulations!</br></center></h1>";
		$monitor->update(CHALLENGE_SUCCESS);
	}
	else{
        echo "<h2 style='color:blue'><br><center>Try Again. That doesn't seem right :( </br></center></h2>";
		$monitor->update(CHALLENGE_FAILURE);
	}
}
?>

<html>
    <head>
        <title> Crypto Challenge: RSA Challenge III</title>
        <meta http-equiv="content-languge" content="en-us" />
        <meta http-equiv="content-type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
    </head>
    
    <body>
        
        <div class="content">
            <h1> RSA Broadcasting with Low Public Exponent</h1>
            
            <div class="story">
                <p>
                    Professor Utonium has finally discovered the a secret formula of Chemical X. <br>
                    He has recently sent an encrypted message to 3 of his colleges, which we believe contains some information about this mysterious chemical <br><br>
                    
                    It is absolutely neccessary for us to learn the formula for defence purposes. 
                    Do everything you need to, to find out the content of the message. 
                    As of now we only know two things, </p>
                <ul>
                    <li>The exact same message (and padding) were encrypted using the public keys of the recipient, i.e. Prof. Utonium encrypted the a message, as <span class="mathcal">M<sup>e</sup> (mod N)  </span>, with variable <span class="mathcal">e,N</span> for different people.</li>
                    
                    <li> He sent it to <strong>3</strong> of his colleagues, all of whose public key encryption exponents were <strong>the same = 3</strong> </li>
                </ul>    
            </div>
            
            <div class="intel">
            
                <p> Here's all the intel we know.<br> <br>
                    The public key of the <span class="mathcal">i-th</span> receipient is,  <span class="mathcal">PK<sub>i</sub> = (e, N<sub>i</sub>) </span>  <br>
                    The corresponding Ciphertexts were computed as,<span class="mathcal">C<sub>i</sub> = M<sup>e</sup> (mod N<sub>i</sub>)  <br> </span>
                    for the i<sup>th</sup> colleague. (<span class="mathcal">M</span> is a OAEP padded message) 
                </p>
            
                <div class="ct">
                        PK<sub>1</sub> = <textarea class="txtar" rows=6 cols=70 readonly> (3, 112527979855417509745872831231152956779525613252863517277399007680553399489958926269951109433120810557332904085220608848593336648183052613882996222106929995856269603528385356480329658577342870351755771946076210022676255230293842336745431837904857340319504948925391380950065693734533992025721098792571281929947)</textarea>
                        <br>
                        C<sub>1</sub> = <textarea class="txtar" rows=5 cols=70 readonly> 10680095142201455814206013377204779891735345003867466171858256925506077916780671120000564509877096693392958034951168015576142766818336125994011531987851115775711867383943835278387429590779120876336748361093329008553064703131524716383684239290941267464395316344869262983816630163448282315359355613550429850399 </textarea>
                </div>

                
                <div class="ct">
                        PK<sub>2</sub> = <textarea class="txtar" rows=6 cols=70 readonly> (3, 141275157369249085864572681642813399643042117024504273699992489105660565380290260779029808599157236116802304761076780935764978394120053175570981679270730495060808658331187314235090079533869151311319197166192767795899736495613121205098468468527623302185408816736994448805818171168620404027580912631054234211439) </textarea>
                        <br>
                        C<sub>2</sub> = <textarea class="txtar" rows=5 cols=70 readonly> 50324273578656106099282209652572140978650442181227198524940456016468709815815578071311408234564109520018984701927445263217052442763317889055693436473951278750671305242303373711373487588583295391362408176509205596402048814773848812449505081829225836143056971030657571588633862700139377141580923703057108769316</textarea>
                </div>
            
                
                <div class="ct">
                        PK<sub>3</sub> = <textarea class="txtar" rows=6 cols=70 readonly> (3, 86317572583529960009884151474296925185465456361208783856007758309476588334131497828820836837827757008957326963912645810493535481880451101950936741580287687001781404573360290494222766595725432940684615079000932826592063124599233838890168840032919901429546978471950243340087310231091758069331657749319333671693) </textarea>
                        <br>
                        C<sub>3</sub> = <textarea class="txtar" rows=5 cols=70 readonly> 22056808728848702737762098754557912633853402574544744131035741664724737140308899719401127265938605512658959521648984214722305014740469806750241835879801797866755896001301951224473165541166042765137900816810372843399580075428979275932819278858955820266367427529508716225403526767144265455337985472974841479949 </textarea>
                </div>
            
            
            </div>
            
            
            <div class="challenge">
                    <span id="ques">What was the (padded) message that was sent out?  </span> <br>
                    <small>(Submit only the <span class="mathcal">M</span>) leave out any leading 0s, i.e the MSB must be non zero) </small>
                    
                    <form method="post" action="index.php" class="form">
                        <textarea rows="8" cols="65" name="msg" placeholder="Decoded (OAEP) Message" class="msg" ></textarea>
                        <br>
                        <input type="submit" class="submit">

                    </form>
            </div>
        
        </div>
        
    
    </body>
</html>