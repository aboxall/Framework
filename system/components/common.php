<?php


// {{{ get_config()

// ensure we have the config class included
require_once 'library/config.php';

function get_config()
{
    // return a singleton instance of the config object
    return Config::getInstance();
}

// }}} end get_config()



// raise_error()

function raise_error($error)
{
    // init the view library
    $view = new View();

    // assign the error message
    $view->assign('error_msg', $error);

    // add the 'error' view
    $view->add('error');

    // output view
    $view->output();

    // end script execution
    exit;
}

// end raise_error()


// EOF
