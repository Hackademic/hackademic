<?php

require_once(HACKADEMIC_PATH."admin/controller/class.ContainerManagerController.php");

$controller = new ContainerManagerController();
echo $controller->go();
