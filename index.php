<?php 
$aux = microtime(true);
error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors', '1' );
ini_set('display_startup', '1');
define('BASE_PATH', realpath(dirname(__FILE__)));
define('APPLICATION_PATH', BASE_PATH . '/application/');
define('LIBRARY_PATH', BASE_PATH . '/library/');
define('CONTROLLERS_PATH', APPLICATION_PATH . 'controllers/');
define('MODELS_PATH', APPLICATION_PATH . 'models/');
define('SCAFFOLDING_PATH', BASE_PATH . '/scaffolding/');
// Let's setup our include paths
set_include_path(
	get_include_path() . PATH_SEPARATOR . 
	BASE_PATH . PATH_SEPARATOR . 
	LIBRARY_PATH . PATH_SEPARATOR . 
	APPLICATION_PATH . PATH_SEPARATOR . 
	CONTROLLERS_PATH . PATH_SEPARATOR .
	SCAFFOLDING_PATH . PATH_SEPARATOR . 
	MODELS_PATH);
// Let's load our Front Controller
require 'FrontController.php';
// Initiate Front Controller

FrontController::getInstance();
echo '<center>Page generated in: '. (string)(round((microtime(true) - $aux),4)) . 'seconds.</center>';
