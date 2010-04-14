<?php

class Route
{
    protected
     $controller,
     $action,
     $params = array(),
     $config;

    public function __construct()
    {
        // get the config object
        $this->config = get_config();

        // parse the request
        $this->parseRequest();

        // check the controller was passed
        if ($this->config->get('request.controller'))
        {
            $this->controller = $this->config->get('request.controller');

            // check if an action was passed
            if ($this->config->get('request.action'))
            {
                $this->action = $this->config->get('request.action');
            }
        }

        if (empty($this->controller))
        {
            // use default controller
            $this->controller = $this->config->get('default.controller');

            // always use default action if no controller is specified
            $this->action = $this->config->get('default.action');
        }

        if (empty($this->action))
        {
            // use default action
            $this->action = $this->config->get('default.action');
        }

        // get the controller in the correct caps
        $this->controller = ucwords($this->controller);

        // append controller name
        $this->controller .= '_Controller';
    }

    public function parseRequest()
    {
        // init the state library
        $state = new State();

        // get the request
        $request = $state->getInput('request');

        if (!empty($request))
        {
            // explode request
            $request_array = explode('/', $request);

            if (!empty($request_array))
            {
                // store the controller
                $this->controller = $request_array[0];
            }

            if (isset($request_array[1]))
            {
                // store the action
                $this->action = $request_array[1];
            }

            if (count($request_array) > 2)
            {
                // foreach extra key
                for ($i = 2; $i < count($request_array); $i++)
                {
                    // store as a param
                    $this->params[$i-2] = $request_array[$i];
                }
            }
        }
    }

    public function getController()
    {
        // return the controller
        return $this->controller;
    }

    public function getAction()
    {
        // return the action
        return $this->action;
    }

    public function getParams()
    {
        // return the request params
        return $this->params;
    }
}

// EOF
