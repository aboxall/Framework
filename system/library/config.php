<?php

class Config
{
    public static $instance = false;
    private $properties = array();

    private function __construct()
    {
        // load default configs

        $this->properties['default'] = array(
            'controller' => 'index',
            'action'     => 'index',
        );

        $this->properties['path'] = array(
            // relative from system path
            'views' => '/application/views',
        );
    }

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    public function get($property)
    {
        $tokens = explode('.', $property);
        $return = $this->properties;

        foreach ($tokens as $token)
        {
            $return = $this->recurseGet($token, $return);

            if (!$return)
            {
                break;
            }
        }

        return $return;
    }

    public function recurseGet($token, $properties)
    {
        if (array_key_exists($token, $properties))
        {
            return $properties[$token];
        }

        return false;
    }

    public function set($property, $value)
    {
        // FIXME

        $tokens = explode('.', $property);
        $count  = count($tokens);

        switch ($count)
        {
            case 1:
                $this->properties[$property] = $value;
                break;
            case 2:
                $this->properties[$tokens[0]][$tokens[1]] = $value;
                break;
            case 3:
                $this->properties[$tokens[0]][$tokens[1]][$tokens[2]] = $value;
                break;
        }

        return true;
    }

    public function printr()
    {
        echo '<pre>'; print_r($this->properties); echo '</pre>';
    }

}

// EOF
