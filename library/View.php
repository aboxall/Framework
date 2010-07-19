<?php
class View
{
	private
		$vars = array(),
		$views = array();
	private static
		$_instance;
	protected
		$viewPath,
		$structure,
		$_config;
		
	public static function getInstance()
	{
		if(!isset(self::$_instance))
			self::$_instance = new View();
			
		return self::$_instance;
	}
	
	public function __construct()
	{
		$this->_config = IniConfig::getInstance();
		
		$this->_viewPath = APPLICATION_PATH . $this->_config->get('application.viewPath');
	}
	
	public function setStructure($structure)
	{
		(string)$this->_filename = $this->_viewPath . '/' . $structure;
		if(file_exists($this->_filename))
			$this->structure = $this->_filename;
	}
	
	public function assign($var_name, $var_val)
	{
		(array)$this->vars[$var_name] = $var_val;
	}
	
	public function add($view, $auto_output = FALSE)
	{
		$this->views[] = $view;
		if($auto_output == true || (string)$this->_config->get('application.ViewOutput') == 'true')
			$this->output();
	}
	
	public function output()
	{
		if((string)$this->_config->get('application.compressPages') == 'true')
			$this->startCompressPages();
		if($this->is_multidimensional($this->views))
			$this->loadMultiView($this->views);
		else
			$this->loadView($this->views);
		if((string)$this->_config->get('application.compressPages') == 'true')
			$this->stopCompressPages();
	}
	
	protected function loadView($loadView)
	{
		foreach ($this->views as $view)
		{
			if(!empty($this->structure) && is_dir($this->structure))
			{
				extract($this->vars);
				$path = $this->structure . '/' . $view . '.php';
				if(file_exists($path))
				include $path;
				else
				require APPLICATION_PATH . 'errors/404.php';
			}
		}
	}
	
	protected function loadMultiView($multiView)
	{
		foreach($this->views as $view)
		{
			foreach($view as $view)
			{
				if(!empty($this->structure) && is_dir($this->structure))
				{
					extract($this->vars);
					$path = $this->structure . '/' . $view . '.php';
					if(file_exists($path))
					{
						include $path;
					}
                    else
						require APPLICATION_PATH . 'errors/404.php';          
				}
			}
		}
	}
	
	protected function startCompressPages()
	{
		if((string)$this->_config->get('application.compressPages') == 'true')
		{
			$this->uriHandler = UriHandler::getInstance();
			if(!$this->Wc3Validator())
			{
				if(substr_count($this->uriHandler->getEncoding(), 'gzip'))
					ob_start("ob_gzhandler");
				else
					ob_start();
			}
		}
	}
	
	protected function Wc3Validator()
	{
		return $this->uriHandler->getUserAgent() ? 
			   $this->_config->get('application.WC3ValidatorUserAgent')
			   : false;
	}
	
	protected function stopCompressPages()
	{
		if((string)$this->_config->get('application.compressPages') == 'true')
		ob_end_flush();
	}
	
	protected function is_multidimensional($array)
    {
        if(!is_array($array))
            throw new Exception('THE_PARSED_VALUES_ARE_NOT_ARRAY');
        else
        {
            $this->filter = array_filter($array, 'is_array');
            if(count($this->filter) > 0)
                return true;
            
        }
    } 
}
