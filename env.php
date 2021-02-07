<?php 
session_start();
// define('DB_HOST', 'mysql10046.xserver.jp');
// define('DB_NAME', 'xs909196_photoblog');
// define('DB_USER', 'xs909196_syun');
// define('DB_PASS', 'Peipei2017');

define('DB_HOST', 'localhost');
define('DB_NAME', 'photoblog');
define('DB_USER', 'syun');
define('DB_PASS', 'Peipei2017');

require_once(__DIR__ . '/dbc.php');
require_once(__DIR__ .'/classes/blog.php');
require_once(__DIR__ . '/classes/UserLogic.php');
require_once(__DIR__ . '/functions.php');
?>