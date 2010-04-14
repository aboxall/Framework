<?php

// get the absolute path to system
$sys_path = dirname(__FILE__);

// set the include path
set_include_path($sys_path . PATH_SEPARATOR . get_include_path());

// include some required components
require_once 'components/common.php';
require_once 'components/autoload.php';

// get config instance
$config = get_config();

// store the system path in config
$config->set('path.system', $sys_path);

// get route library
$route = new Route();

// get controller, action and request params
$controller = $route->getController();
$action     = $route->getAction();
$params     = $route->getParams();

// store in config
$config->set('request.controller', $controller);
$config->set('request.action', $action);
$config->set('request.params', $params);

// init the application
$application = new Application($controller, $action);

// EOF
