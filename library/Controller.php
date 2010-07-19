<?php
abstract class Controller
{
	protected
		$config,
		$view;
	public function __construct()
	{
		$this->view = View::getInstance();
		$this->config = IniConfig::getInstance();
	}
	
	abstract public function index();
}
