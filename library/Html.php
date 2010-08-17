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
	
	public static function anchor($link, $text, $title, $extras)
	{
	    $domain = self::domain();
    	$link = $domain . $link;
    	$data = '<a href="' . $link . '"';
    
    	if ($title)
    	{
    		$data .= ' title="' . $title . '"';
    	}
    	else
    	{
    		$data .= ' title="' . $text . '"';
    	}
    
    	if (is_array($extras))//2
    	{
    		foreach($extras as $rule)//3
    		{
    			$data .= self::parse_extras($rule);//4
    		}
    	}
    
    	if (is_string($extras))//5
    	{
    		$data .= self::parse_extras($extras);//6
    	}
    
    	$data.= '>';
    
    	$data .= $text;
    	$data .= "</a>";
    
    	return $data;
	}
	
	public static function link()
	{
	}
	
	public static function mailto()
	{
	}
	
	/**
	 * 
	 * @param (string) $data
	 * @param (string) $type
	 * @param (int) $width
	 * @param (int) $height
	 * @param (string) $name
	 */
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
		$controller = $_config->get('uriParsed.controller') . 'Controller';
		$defaultCssFiles = $_config->get('css.default');	
		$cssFile = $_config->get('css.'. $controller);
		foreach($defaultCssFiles as $cssKeyDefault)
		{
		    $cssKeyDefault = explode('|', $cssKeyDefault);
			echo '<link rel="stylesheet" href="public/css/'. $cssKeyDefault[1] .'.css" type="text/css" media="'. $cssKeyDefault[0] .'" />
';
		}
		
		foreach($cssFile as $cssKeyFile)
		{
		    $cssKeyFile = explode('|', $cssKeyFile);
		    echo '<link rel="stylesheet" href="public/css/'. $cssKeyFile[1] .'" type="text/css" media="'. $cssKeyFile[0] .'" />
';
		}
	}
	
    public static function parse_extras($rule)
    {
    	if ($rule[0] == "#") //1
    	{
    		$id = substr($rule,1,strlen($rule)); //2
    		$data = ' id="' . $id . '"'; //3
    		
    		return $data;
    	}
    
    	if ($rule[0] == ".") //4
    	{
    		$class = substr($rule,1,strlen($rule));
    		$data = ' class="' . $class . '"';
    		
    		return $data;
    	}
    
    	if ($rule[0] == "_") //5
    	{
    		$data = ' target="' . $rule . '"';
    		
    		return $data;
    	}
    }
}
