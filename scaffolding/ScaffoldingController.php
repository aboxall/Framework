<?php
class ScaffoldingController extends Model
{
	public
		$connectionName = 'test';
	public function __construct($name)
	{
		echo $name;
	}
	public function index()
	{
	}
	public function dispatch($name)
	{
		$connectionName = $name;
	}
}
