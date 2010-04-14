<?php

class State
{
    public function getInput($name, $method = 'REQUEST')
    {
        $method = strtoupper($method);

        if (!in_array($method, array('POST', 'GET', 'REQUEST')))
        {
            return false;
        }

        $request = '_' . $method;

        // ugly hack!
        global $$request;

        if (!isset(${$request}[$name]))
        {
            return false;
        }

        return ${$request}[$name];
    }

    public function startSession()
    {
        session_start();
    }

    public function getSessionVar($name)
    {
        if (!isset($_SESSION[$name]))
        {
            return false;
        }

        return $_SESSION[$name];
    }

    public function setSessionVar($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function getCookieVar($name)
    {
        if (!isset($_COOKIE[$name]))
        {
            return false;
        }

        return $_COOKIE[$name];
    }
}

// EOF
