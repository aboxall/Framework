<?php
class IndexController
{	
	public $view;
	public function index()
	{
		$this->config = IniConfig::getInstance();
		$this->view = View::getInstance();
		$this->config->parseIniFile('css.ini', false);
		$this->view->setStructure('index');
		$this->view->assign('sex', 'sss');
		$this->view->add('index');
	}
	
	public function hello()
	{
		echo "Hello World From: " . __METHOD__;
	}
}
