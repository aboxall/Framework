<?php

class Application
{
    protected $controller;

    public function __construct($controller, $action)
    {
        try
        {
            // init the controller
            $this->controller = new $controller;

            // check if the action exists for the controller
            if (method_exists($this->controller, $action))
            {
                // call it if it does
                call_user_func(array($this->controller, $action));
            }
            else
            {
                // throw an exception
                throw new Exception('Unable to call controller action: ' . $action);
            }
        }
        catch (Exception $e)
        {
            // default error handler for any uncaught exceptions
            // exception handling will be imrpoved
            raise_error($e->getMessage());
        }        
    }
}


?>
