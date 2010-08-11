<?php
class IndexModel extends Model
{
	public
		$connectionName = 'test';
	public function __construct() 
	{
		parent::__construct();
	}

	public function insertPost($array)
	{
	    $this->Insert($array);
	}
}

?>