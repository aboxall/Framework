<?php
class AutoLoaderExceptions extends Exception
{
    public function loadErrorPage($code)
    {
		try
		{
			require_once APPLICATION_PATH . 'errors/404.php';
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
    }
    
    public function __toString()
    {
        return get_class($this) . " in {$this->file}({$this->line})".PHP_EOL
                                ."'{$this->message}'".PHP_EOL
                                . "{$this->getTraceAsString()}";
    }

}
