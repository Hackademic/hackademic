<?php

/**
 *    ----------------------------------------------------------------
 *    OWASP Hackademic Challenges Project
 *    ----------------------------------------------------------------
 *    Copyright (C) 2010-2011
 *      Andreas Venieris [venieris@owasp.gr]
 *      Anastasios Stasinopoulos [anast@owasp.gr]
 *    ----------------------------------------------------------------
 */

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
    <title>Challenge 003</title>
    <center>
<body bgcolor="black">
<img src="xssme1.png">
<font color="green"/>
</head>
<body>
<h2>
    <hr>
    <?php
    include_once dirname(__FILE__) . '/../../init.php';
    session_start();
    require_once(HACKADEMIC_PATH . "controller/class.ChallengeValidatorController.php");

    $solution = new RegexSolution(RegexSolution::JS_BEGIN . 'alert\("XSS!"\)' . RegexSolution::JS_END);
    $validator = new ChallengeValidatorController($solution);
    $validator->startChallenge();
    $_SESSION['init'] = true;

    if (isset($_POST['try_xss'])) {
        $answer = $_POST['try_xss'];
        $valid = $validator->validateSolution($answer);
        if ($valid) {
            echo $answer;
            echo "<h1>Congratulations!</h1>";
            exit();
        }
    }
    ?>
    Try to XSS me using the straight forward way... <br/>
    <form method="POST">
        <input type="text" name="try_xss"/>
        <input type="submit" value="XSS Me!"/>
    </form>
    <hr>
</h2>
</body>
</html>

