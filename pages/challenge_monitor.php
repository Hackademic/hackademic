<?php
require_once dirname(dirname(__FILE__))."/init.php";
require_once HACKADEMIC_PATH."controller/class.ChallengeMonitorController.php";

$monitor = new ChallengeMonitorController();
$monitor->go();