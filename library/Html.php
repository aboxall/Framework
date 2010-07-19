<?php
class Html
{
	protected static
		$_instance;
	protected
		$_config;
	public static function getInstance()
	{
		if(!isset(self::$_instance))
			self::$_instance = new Html();
			
		return self::$_instance;
	}
	
	public static function domain()
	{
		$_config = IniConfig::getInstance();
		return $_config->get('application.domainName');
	}
	
	public static function image($src, $params)
	{
		echo "<pre>";
		print_r($params);
		$rule = 'alt.';
		$id = substr($rule, -4, strlen($params[0]));
		echo $id;
		$src = self::domain() . '/public/images/' .$src;
		$image = '<img src="'. $src .'"';
		if(!empty($params[0]))
		$image .= 'width="'. $params[0] .'"';
		if(!empty($params[1]))
		$image .= 'height="'. $params[1] .'"';
		if(isset($params[2]))
		$image .= ' alt="'. $params[2] .'"';
		$image .= '/>';
		
		return $image;
	}
	
	public static function anchor()
	{
	}
	
	public static function link()
	{
	}
	
	public static function mailto()
	{
	}
	
	public static function flash($data, $type, $width, $height, $name)
	{
		$data = '<object
				type="'. $type .'"
				data="'. $data .'"
				width="'. $width .'" height="'. $height .'">
				<param name="'. $name .'"
				value="'. $data .'" />
				</object>
';
	}
	
	public static function addCss()
	{
		$_config = IniConfig::getInstance();
		$_config->printAll();
		$cssFile = $_config->get('css');
	}
}
