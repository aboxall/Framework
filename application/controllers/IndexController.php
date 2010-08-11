<?php
class IndexController extends Controller
{
	public
		$table,
		$values;

	public function isndex()
	{
		
	}

	/**
	 * 
	 * @param unknown_type $table
	 * @param unknown_type $values
	 */
	public function index()
	{
    	$insert = array(
            'post' => array(
                array('null',  '1',  'My First Title',  'My First Text'),
            ),
        );
        $indexModel = new IndexModel();
        $indexModel->insertPost($insert);
	}
	
	public function implodeValues($array)
	{
		return '(:' . implode(', :', $array) . ')';

	}
}