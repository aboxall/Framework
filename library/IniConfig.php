<?php
class IniConfig
{
	public static
		$_instance;
	protected
		$_iniFile,
		$_tokens,
		$_token,
		$_path,
		$_basename;
	
	public
		$_propertyReference = array();
	
	public static function getInstance()
	{
		if(!isset(self::$_instance))
			self::$_instance = new IniConfig();
			
		return self::$_instance;
	}
	
	protected function __construct() {}
	protected function __clone() {}
	
	public function parseIniFile($filename, $Iniprocess_section = TRUE,  $Inipath = NULL)
	{
		if(!empty($Inipath))
		{
			$this->_IniFile = $Inipath . '/' . $filename;
			$filename = basename($this->_IniFile, '.ini');
		}
		else
		{
			$this->_path = APPLICATION_PATH . 'configs/';
			$this->_IniFile = $this->_path . $filename;
			$filename = basename($filename, '.ini');
		}
		if(file_exists($this->_IniFile))
		{
			$this->_properties[$filename] = 
				parse_ini_file($this->_IniFile, $Iniprocess_section);
		}
		else
			trigger_error("Configuration Not Found");
	}
	
	public function get($property)
    {
        // Extract data
        $this->_tokens = explode('.', $property);

        // Setup our point of reference
        $_propertyReference = &$this->_properties;
                                                       
        // Let's see what we got here
        foreach($this->_tokens as $this->_token)
        {                   
            // check if the array key exists - if this check wasn't in
            // place the property key would be created automatically
            if(!array_key_exists($this->_token, $_propertyReference))
                return false;
            
            // build up the array pointer
            $_propertyReference = &$_propertyReference[$this->_token];
        }
        // Let's give something to the user!
        return $_propertyReference;
    }
    
    public function set($property, $value)
    {
        // Extrac Data
        $this->_tokens = explode('.', $property);
        
        // Let's create a referenec point for the Properties array
        $this->_propertyReference = &$this->_properties;
        
        // Let's see what the user served us!
        foreach($this->_tokens as $this->_token)
        {
            // Let's build the array pointer
            $this->_propertyReference = &$this->_propertyReference[$this->_token];
        }
        
        // Let's set what the user asked us.
        $this->_propertyReference = $value; 
    }
    
    public function printAll()
    {
		echo "<pre>";
		print_r($this->_properties);
	}
}
