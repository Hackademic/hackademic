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
define('SITE_ROOT_PATH', "/appsec/hackademic/");

// Full server path to /hackademic/ folder.
define('SOURCE_ROOT_PATH', "http://bubblegum/appsec/hackademic/");

// Toggle Smarty caching. true: Smarty caching on, false: Smarty caching off
define('DEBUG',false);
define('CACHE_PAGES',false);

// Environment
// TODO: change to production once we finish the merge
define('ENVIRONMENT', 'dev');

/************************************************/
/***  DATABASE CONFIG                         ***/
/************************************************/

define('DB_HOST', 'localhost');
define('DB_TYPE', 'mysql');
define('DB_USER', 'root');
define('DB_PASSWORD', 'northy');
define('DB_NAME', 'appsec');


/*********************************************/
/** 	Various Config			*****/
/********************************************/

//default max challenge size
define('MAX_CHALLENGE_SIZE','2097152');

/*	DEV DEBUG MESSAGE SELECTION */

//Debug message selection
define('SHOW_SQL_QUERIES', '#TRUE OR FALSE');
define('SHOW_SQL_RESULTS', '#TRUE OR FALSE');
define("SHOW_EMPTY_VAR_ERRORS", '#TRUE OR FALSE');



/***************************************
**	Default Example Challenge Path**
***************************************/
define('EXAMPLE_CHALLENGE','challenges/Example/');


/***************************************
**	"Security" settings "**
***************************************/

//every session closes after 48 hours
define('SESS_EXP_ABS',172800);

//every session closes after 2 hours of inacivity
define('SESS_EXP_INACTIVE',7200);

//session cookie name
define('SESS_NAME',"not_the_cookie_you_are_looking_for");

//excibition mode
define('EXHIBITION_MODE',false);

//the installation language
define('LANG','EN');

/* Unit Testing Variables*/
define('TEST_USERNAME_ADMIN','#THE_USERNAME_FOR_TESTS');
define('TEST_PASSWORD_ADMIN','#THE_PASSWORD_FOR_tESTS');
