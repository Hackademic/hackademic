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

if(isset($_POST['privateExp'])){
    $result = trim($_POST["privateExp"]);
    if ($result < 17179879185 and $result > 17179859185){
        echo "<h1 style='color:blue'><br><center>Congratulations!</br></center></h1>";
        $monitor->update(CHALLENGE_SUCCESS);
    }
    else{
        echo "<h2 style='color:blue'><br><center> Try Again :( </br></center></h2>";
        $monitor->update(CHALLENGE_FAILURE);
    }
}
?>

<html>
    <head>
        <title> Crypto Challenge: Small Private Key Exponents</title>
        <meta http-equiv="content-languge" content="en-us" />
        <meta http-equiv="content-type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
    </head>
    
    <body>
    
        <div class="content">
            <div class="story">
                <h2 class="header"> Finding Faults with Small Private Keys</h2>
                <p>
                An anonymous private banking group has a system that needs to be audited and you are invited to spearhead the operation with a Red Team of your choosing.
                    <br>
                Because of the client's request for anonymity, we only here give you the general scheme, and not the implementation details.
                    <br>
                The System you are built using a RSA Cryptosystem. The client's IT department chose them a really low Private Key Exponent so that they the decryptions can be done fast.
                    <br>
                However, we are convinced that this is a bad idea, and it may be possible to fully break the scheme by means of approximating the private key exponent. 
                </p>    
            </div>
        
            
            <div class="details">
                Here are the details of the scheme:
                <br>
                Public Key, <strong>(N,e)</strong> = <textarea class="txtar" rows=13 cols=70 readonly>(67091520080662390215228639525986848203906883946254886466910857975814324815720740297554892006015708888932646819916935533573208109661576877022483655609516684408257043670924338325015779724569511764159193575598425318492635082259123051757439006574123038948702630617069561967645026811793488384801696801377837788921, 
                57309173288269001392944412054551182207620127678357650587370750626561459531721024421355396408875793494267635875697981170294108639049136097374906626042864883890749888435377674513542938351844758423397026667692660157330030305605085557081788707276974019184663242858847088036560553036245660579225517790361459033425 ) </textarea>
                <br> <br> <br>
                Every message <span class="mathcal">m</span> is padded with using PKCS standards, deemed secure by industry experts. <br><br>
                
            </div>
        
            
            <div class="chal"> 
                Choosing a low Private Exponent is a terrible idea. <br>
                Your Objective is to estimate the private key exponent (±10000). 
                
                <form method="post" action="index.php" class="form">
                    <input type="text"  name="privateExp" class="answer" size="65">
                        <br>
                        <input type="submit" class="submit">
                    </form>
            
            </div>

        </div>
        
    
    </body>
</html>