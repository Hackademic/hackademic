<?php

$version = explode('.', PHP_VERSION);
if ($version[0] < 5) {
    echo "ERROR: Hackademic requires PHP 5. ";
    echo "The current version of PHP is ".phpversion().".";
    die();
}
if (!file_exists('config.inc.php')) {
    header("Location: ./installation/install.php");
    error_log("Couldn't find config file, installing");
    die("No config");
}
require_once 'init.php';

$url = isset($_GET['url']) ? $_GET['url'] : '';
if ($url != '') {
    require_once HACKADEMIC_PATH."model/common/class.Page.php";
    $path = Page::getFile($url);
    include_once HACKADEMIC_PATH.$path['file'];
} else {
    require_once HACKADEMIC_PATH."controller/class.LandingPageController.php";
    $controller = new LandingPageController();
    echo $controller->go();
}
