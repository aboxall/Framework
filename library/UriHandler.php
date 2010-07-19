<?php
class UriHandler
{
	public static
		$_instance;
		
	public static function getInstance()
	{
		if(!isset(self::$_instance))
			self::$_instance = new UriHandler();
		
		return self::$_instance;
	}	
	public function queryString()
	{
		return $_SERVER['QUERY_STRING'];
	}
	
	public function getScriptName()
	{
		return $_SERVER['SCRIPT_NAME'];
	}
	
	public function requestUri()
	{
		return $_SERVER['REQUEST_URI'];
	}
	
	public function getPathInfo()
	{
		return $_SERVER['PATH_INFO'];
	}
	
	public function getUserAgent()
	{
		return $_SERVER['HTTP_USER_AGENT'];
	}
	
	public function getEncoding()
	{
		return $_SERVER['HTTP_ACCEPT_ENCODING'];
	}
}
