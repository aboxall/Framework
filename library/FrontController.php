<?php
require 'IniConfig.php';
require 'Autoloader.php';
require 'ArrayHandler.php';
class FrontController
{
	private static
		$_instance;
	
	protected
		$_config;
		
	public
		$iniFile;
		
	public static function getInstance()
	{
		if(!isset(self::$_instance))
			self::$_instance = new FrontController();
			
		return self::$_instance;
	}
	
	protected function __construct()
	{
		$this->_config = IniConfig::getInstance();
		$this->_config->parseIniFile('application.ini', false);
		$this->_config->parseIniFile('css.ini', false);		
		spl_autoload_register(array(AutoLoader::getInstance(), 'autoLoader'));
		StandardRouter::route();
	}
}
