<?php 
$aux = microtime(true);
error_reporting(E_ALL);
ini_set('display_errors', 'on');
define('BASE_PATH', realpath(dirname(__FILE__)));
define('APPLICATION_PATH', BASE_PATH . '/application/');
define('LIBRARY_PATH', BASE_PATH . '/library/');
define('CONTROLLERS_PATH', APPLICATION_PATH . 'controllers/');

// Let's setup our include paths
set_include_path(
	get_include_path() . PATH_SEPARATOR . 
	BASE_PATH . PATH_SEPARATOR . 
	LIBRARY_PATH . PATH_SEPARATOR . 
	APPLICATION_PATH . PATH_SEPARATOR . 
	CONTROLLERS_PATH);

// Let's load our Front Controller
require 'FrontController.php';
// Initiate Front Controller
FrontController::getInstance();
echo '<center><br />Page generated in: '. (string)(round((microtime(true) - $aux),4)) . 'seconds.</center>';
