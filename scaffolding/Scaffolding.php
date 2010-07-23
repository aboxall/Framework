<?php
class Scaffolding extends Model
{
	public function __construct()
	{
		$this->_config = IniConfig::getInstance();
		$this->_config->printAll();
		echo $this->_config->get('uriSegment.3');
	}
}
