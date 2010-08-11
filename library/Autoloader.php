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
        $directoryIteratorController = new DirectoryIterator(APPLICATION_PATH . 'controllers');
        foreach($directoryIteratorController as $directoryIteratorControllers)
        {
			if($directoryIteratorControllers->isDir())
				set_include_path(get_include_path() . PATH_SEPARATOR . $directoryIteratorControllers->getPathInfo() . '/');
				
		}
		
		$this->_paths = explode(PATH_SEPARATOR, get_include_path());
    }
    
    public function autoLoader($className) 
    {
		$fileName = $className . '.php';
		try
		{
			foreach($this->_paths as $filePath)
			{
				if(is_file($filePath . $fileName))
				{
					require_once $fileName;
					
					return true;
				}
			}
			if(!class_exists($fileName, false))
				throw new AutoloaderExceptions("Class $fileName Missing In $fileName	");
		}
		catch(AutoloaderExceptions $e)
		{
			header("HTTP/1.0 500 Internal Server Error");
			$e->loadErrorPage('500');
			exit;
		}
    } 
}
