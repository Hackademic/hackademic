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
	if ($result === "9e72dee50c49490c690255e0b8fac505b1368492"){
		echo "<h1 style='color:white'><br><center>Congratulations!</br></center></h1>";
		$monitor->update(CHALLENGE_SUCCESS);
	}
	else{
        echo "<h2 style='color:white'><br><center>Try Again. That doesn't seem right :( </br></center></h2>";
		$monitor->update(CHALLENGE_FAILURE);
	}
}
?>



<html>
    <head>
        <title> Crypto Challenge: RSA Challenge II</title>
        <meta http-equiv="content-languge" content="en-us" />
        <meta http-equiv="content-type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
    </head>
    
    <body>
        
        
        <div class="content">
            <h1> RSA Challenge II</h1>
            <div class="story">   
                <p>There was a recent break-in in our organization and before we could arrest the attack, there was an encrypted message, that was send out to some top level executives of FMA Inc. 
            
                <br>
            
                After necessary research, all we know now are the following facts, </p>
                <ul>
                    <li>all FMA executives share a common RSA modulas, while have different enc exponenets </li>
                    <li> the message was padded using OAEP, only once, i.e. all <span class="math">c<sub>i</sub> = (m)<sup>e<sub>i</sub></sup> </span>  observe <span class="math">m</span> is common to all </li>
                </ul>    

                <p>
                We need you to further investigate this and tell us what was the initial padded message i.e. <span class="math">m</span>
                <br>
                Find the information on ciphertexts and corresponding public keys below, and use that to break the scheme. 
                <br>
                Submit your findings of the message in Decimal form, and remember to submit the padded message, do not invert the padding function.</p>
            
                <p> <small> Hint: To verify your results you can check by enc. a msg of your choice and then trying to retrieve it. Use can <a href="files/sanity_check.txt"> this file </a> also. </small></p>
            
            
                <div class="challenge_setup">
                    <strong> Common RSA Modulas, N: </strong>    

            
                    <textarea class="txtar" rows=11 cols=55 onclick="this.select()" readonly> 17550854161026967298898773324535395888503667059666284684657398219614421388818931137572711813554506417779651609143469679478857327463765086885390351944342938576572181127918383810676848344226223071205693565270403281302657157274650949414099368142876660186988487901180814158748660861342597583507159187997483403324423664171392227645731469011118516464049847873347013837263505927789670091836046966648843184621616492483846712385894972020048785071522736311140708096606519295201701057330526144719626691878490407366519346196188060660823786744310426175565505532185400976796612521064577725669318896156014857242005431381977112608371 </textarea>


                    
                    <div class="ct">
                        e<sub>1</sub> = 48809
                        <br>
                        c<sub>1</sub> = <textarea class="txtar" rows=9 cols=70 readonly> 11134708761804502463711746674484194676555329358772940978630607533060695178341976879235312847781495009134827953271796264197186867467071685565252756445229181215971774745891438535812631029770847253400413801063454935589912243583754154095876433688146727119089603068675504690955858900405843719016986388255076238564172165628331497714039984550615481233263309700998365125360718200238070157612524453951668312433038079157890018459084700487051631661523091038520358498929497267705233117047860170592685176428322397561149774921116007575982970421199745638942282800043521672366364258388033274725557956579749345742824695293688915565241 </textarea>
                    </div>
                
                    
                        
                    <div class="ct">
                        e<sub>2</sub> = 43261
                        <br>
                        c<sub>2</sub> = <textarea class="txtar" rows=9 cols=70 readonly> 14458265163629869255542044827601941604103506772524330871707587387682754325570941849265958933469899828296047510847377223256200331086494907765858886606489969825707651268475610876891919066160349252876065426684587742454910111940617871036289446431318381149224773037096132054239308461032037613051367858177304714276017450180937405562596843101583115909784236267011424798859163449775696732215219107491129467745445820120288693266765144934207600936061842579339988461340008471308751635069346018990678709994039778541536078925908522815016998926600633326891259033675864920733942392529925502058283918465447104007022892034248761405204 </textarea>
                    </div>
                    
                    
                        
                    <div class="ct">
                        e<sub>3</sub> = 59617
                        <br>
                        c<sub>3</sub> = <textarea class="txtar" rows=9 cols=70 readonly> 14946653062636947438487338493780740522765309281596175955095121729113672039286894310402538256077581032288899201295574548767517705803588558117024233879122983019759583966487131130876293081754298176013905507400772018894541145768331043598609660991327756563156892490560685472887292648981873605090965257338717049486095378110233157221712414928072832623925985317064002489962970043158940895751034567130676621654542510635261952085242672001096436503048983922590185871019967460297826900932536059525247022028917361968521282422038995991121129132401720609994978584090412351271488155987501793883194267886049987175887496364873507573159 </textarea>
                    </div>
                    
                    
                        
                    <div class="ct">
                        e<sub>4</sub> = 39979
                        <br>
                        c<sub>4</sub> = <textarea class="txtar" rows=9 cols=70 readonly> 9277441489195458792578948940625496593206059496917425751358588310232289868878971345984260945394041007786926829100796870033902575918636727529739161981467764617152384175929387585076714612177838709890290182566361877952211141528503158485028940349813798601721238381420246189033073277335254267670495260151650817244926434757938798653366410356327422495363981938374878630814173205067825003844618156335110440164594940515540310015579791683405866040071197931628212952324056759639636462814793616756497649958856052335987870054050488985281723920692058631925441637839600826305712320859614089722617947622416535070973294413935175339532 </textarea>
                    </div>
                    
                
                        
                    <div class="ct">
                        e<sub>5</sub> = 473971 
                        <br>
                        c<sub>5</sub> = <textarea class="txtar" rows=9 cols=70 readonly> 2859628898848731457732339739304934667015946328000347137915346654740270440082222947157031947115233695561933910937465177881702314203540091991582143252305413763992833933879566922616961879836743448731508909500789857540501594127077422892758140335581870916239246216042179830724315654540908075329025047696382059517734278569252236793196188512349746649869869893655740235293543348558645243097561509415031802886586264553490347791855713668107925981689470967619117056063582508610322423848666488221453301427200867542911899781943268569668683884393574230042650379216585458616901533292832915439420327535335185297243148299769275883618 </textarea>
                    </div>
                
                
                </div>    
             
                <div class="challenge">
                    <span id="ques">What was the (padded) message that was sent out?  </span>
                    <small>(leave out any leading 0s, i.e the MSB must be non zero) </small>
                    
                    <form method="post" action="index.php" class="form">
                        <textarea rows="8" cols="65" name="msg" placeholder="Decoded (OAEP) Message" class="msg" ></textarea>
                        <br>
                        <input type="submit" class="submit">

                    </form>
                </div>
                    
              
    
            </div>
        
        
        </div>
        
        
        
    
    
    
    </body>
</html>
