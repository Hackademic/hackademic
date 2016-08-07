<?php
/************************************************/
/***  APPLICATION CONFIG                      ***/
/************************************************/
/**
 * Main configuration file for Hackademic CMS. It initializes all the global
 * variables for the application.
 */

// Application title
define('APP_TITLE', '#YOUR_APP_TITLE_HERE#');

// Public path of hackademic's folder on your web server.
// For example, if the  folder is located at http://yourdomain/hackademic/, set to '/hackademic/'.
define('SITE_ROOT_PATH', "#YOUR_SITE_ROOT_PATH#");

// Full server path to /socialcalc/ folder.
define('SOURCE_ROOT_PATH', "#YOUR_SOURCE_ROOT_PATH#");

// Toggle Smarty caching. true: Smarty caching on, false: Smarty caching off
define('DEBUG',false);
define('CACHE_PAGES',false);

// Environment
define('ENVIRONMENT', 'production');

/************************************************/
/***  DATABASE CONFIG                         ***/
/************************************************/

define('DB_HOST', '#YOUR_DBHOST#');
define('DB_TYPE', 'mysql');
define('DB_USER', '#YOUR_DBUSER#');
define('DB_PASSWORD', '#YOUR_DBPASS#');
define('DB_NAME', '#YOUR_DBNAME#');
asdf
