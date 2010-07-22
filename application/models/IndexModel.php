<?php
class IndexModel extends Model
{
	protected 
		$connectionName = 'test';
	
	public function __construct()
	{
		parent::__construct();
		$records = $this->rawSelect("SELECT * FROM `post`");
		$row = $records->fetchALL(PDO::FETCH_ASSOC);
	}
}
