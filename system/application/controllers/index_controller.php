<?php

class Index_Controller
{
    public function __construct()
    {
        $this->view = new View();
    }

    public function index()
    {
        // set to index view directory
        $this->view->setStructure('index');

        // add the homepage view
        $this->view->add('homepage');

        // assign some text
        $this->view->assign('test', 'Hello, World!');

        // output view
        $this->view->output();
    }


}

// EOF
