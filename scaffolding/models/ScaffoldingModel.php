<?php
class ScaffoldingModel extends Model
{
	public function __construct($connectionName)
	{
		$this->connectionName = $connectionName;
		parent::__construct();
	}
}
