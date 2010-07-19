<?php
require APPLICATION_PATH . 'exceptions/AutoloaderExceptions.php';
class AutoLoader 
{
    private static 
        $_instance;
    protected
        $_config,
        $_paths = array(),
        $_path;
    public
        $className;
    
    public static function getInstance() 
    {
        if (!isset(self::$_instance))
        {
            self::$_instance = new AutoLoader();
        }
        
        return self::$_instance;
    }

    private function __construct() 
    {
        $this->_paths = explode(PATH_SEPARATOR, get_include_path());
    }
    
    public function autoLoader($className) 
    { 
        $this->loadFile($className);
        try
        { 
            if(!class_exists($className, false)) 
            { 
                throw new AutoloaderExceptions("Class: " . $className . " Is not Defined"); 
            }
        }
        catch(AutoLoadException $e)
        {
            echo $e->getMessage();
            exit();
        } 
    } 
    
    protected function loadFile($className) 
    {
        if(preg_match('/_/', $className))
        {
			$className = str_replace('_', DIRECTORY_SEPARATOR, $className . '.php');
			if(file_exists($className))
				require $className;
		}
		else
		{
			foreach($this->_paths as $this->_path) 
			{ 
				//echo $this->_path . '<br />';
				$this->_path = $this->_path . $className . '.php';  

				if(file_exists($this->_path)) 
				{ 
					require $this->_path; 
					break; 
				} 
			} 
		}
    } 
}
