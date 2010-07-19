<?php
class RubyRouter
{
	public
		$uriHandler,
		$controller,
		$action = 'Index';
	protected static
		$_pathComponents,
		$pathComponents;
		
	
	public static function route()
	{
		// Let's prepare our data...
		$uriHandler = UriHandler::getInstance();
		$url = self::explodeComponents('?', $uriHandler->requestUri());
		$path = mb_strtolower($url[0]);
		while(substr($path, -1) == '/')
		{
			$path = mb_substr($path,0,(mb_strlen($path)-1));
		}
		
		$pathComponents = self::explodeComponents('/', $path);
		print_r($pathComponents);
	}
	
	public function explodeComponents($pattern, $handle)
	{
		return $_pathComponents = explode($pattern, $handle);
	}
}
