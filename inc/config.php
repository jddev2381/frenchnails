<?php


session_start();



//define('SITE_URL', 'http://frenchnails.bobahut.net/');

define('SITE_URL', 'http://localhost:2381/');

define('SITE_NAME', 'French Nails Queue');

define('SEND_EMAIL_TO', 'jd@huntingtonwebsolutions.com');


// DB Params
define('DB_HOST', 	'localhost');


define('DB_USER', 	'root');


define('DB_PASS', 	'123456');

//define('DB_NAME', 	'frenchNails');
define('DB_NAME', 	'french_nails');


// error_reporting(E_ALL);
// ini_set("display_errors", 1);


$ipAddress = $_SERVER['REMOTE_ADDR'];

$hands = '';
$feet = '';
