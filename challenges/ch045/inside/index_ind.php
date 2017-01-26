<?php

//print_r ($_POST);

?>
<!DOCTYPE html>
<html>
<center>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css" media="screen" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />


<script src="js/html5.js"></script>

<title></title>

</head>

<body>


<div id="main">

    <?php

    if(isset($_POST['searchfield']))
    {

        $target = $_POST['searchfield'];

        if($target == "")
        {

            echo "<font color=\"red\">Invalid text</font>";

        }

        else
        {
           // echo "1"."<br/>";
          
                $target = str_replace("&", "", $target);
                $target = str_replace(";", "", $target);
             // $target = str_replace("|", "", $target);
                $target = str_replace("(", "", $target);
                $target = str_replace(")", "", $target);
                $target = str_replace("$", "", $target);
                echo "<br/>";
                //echo $target;
                //echo "<br/>";
               // $target = escapeshellcmd($target);
                // echo "<br/>";
                // echo $target;
                // echo "<br/>";

                $cmd .= shell_exec("ping -c 3 " . $target);

                //echo "4"."<br/>";

                echo $cmd;

                //echo "<br/>";
                //echo "5"."<br/>";


        }

    }

    ?>

</div>

</body>
</center>
</html>