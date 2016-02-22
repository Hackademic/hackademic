<?php
/**
 * Created by atom.
 * User: AnirudhAnand (a0xnirudh)
 * Date: 2/10/15
 * Time: 3:03 PM
 */

$file = "src.php";
$fh = fopen("/tmp/" . $file, 'w');

$stringData = "<?php

class Src {
"
;
fwrite($fh, $stringData);
$stringData = $_POST['function'];
fwrite($fh, $stringData);
$stringData = "\n }";
fwrite($fh, $stringData);
fclose($fh);
//system('rm unittest.php');
echo system('phpunit unittest.php');
system('rm /tmp/src.php');
