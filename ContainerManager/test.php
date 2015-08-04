<?php
$abc = exec('python create_container.py webchallenge1');
header("Location: ".$abc);
exit;
?>
