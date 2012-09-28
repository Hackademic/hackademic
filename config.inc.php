<?php
/************************************************/
/***  APPLICATION CONFIG                      ***/
/************************************************/
/**
 * Main configuration file for Hackademic CMS. It initializes all the global
 * variables for the application.
 */

// Application title
define('APP_TITLE', 'Hackademic CMS');

// Public path of hackademic's folder on your web server.
// For example, if the  folder is located at http://yourdomain/hackademic/, set to '/hackademic/'.
define('SITE_ROOT_PATH', "/hackademic/");

// Full server path to /socialcalc/ folder.
define('SOURCE_ROOT_PATH', "http://localhost/hackademic/");

// Toggle Smarty caching. true: Smarty caching on, false: Smarty caching off
define('DEBUG',false);
define('CACHE_PAGES',false);

// Environment
define('ENVIRONMENT', 'production');

/************************************************/
/***  DATABASE CONFIG                         ***/
/************************************************/

define('DB_HOST', 'localhost');
define('DB_TYPE', 'mysql');
define('DB_USER', 'hack');
define('DB_PASSWORD', 'northy');
define('DB_NAME', 'hackademic');
