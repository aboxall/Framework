<?php

function __autoload($class)
{
    // parse the class into the correct file format
    $class_file = strtolower($class) . '.php';

    // an array of possible paths containing the class
    $paths = array(
        'library/',
        'application/controllers/',
        'application/models/',
        'application/library',
    );

    // get the config object
    $config = get_config();

    // get the system path
    $sys_path = $config->get('path.system');

    // loop through the paths
    foreach ($paths as $path)
    {
        // append the system path
        $path = $sys_path . '/' . $path;

        // append the class file to each path
        $path .= $class_file;

        // check if the file exists
        if (file_exists($path))
        {
            // include the class
            require_once $path;

            // break once we have a matching path
            break;
        }
    }

    // check if we have the class
    if (!class_exists($class))
    {
        // fake the class' existence if not
        eval("class " . $class . "{}");

        // raise custom error
        raise_error('Cannot find class: ' . $class);
    }
}

// EOF
