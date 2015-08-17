<?php
$abc = exec('python test.py create_container webchallenge1');
echo $abc;
header("Location: ".$abc);
exit(0);
?>
