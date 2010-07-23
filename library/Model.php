<?php
class Model extends PDO
{
	protected
		$_config;
	private
		$connectionDetails,
		$dsn,
		$username,
		$password;
		
	public function __construct()
	{
		try
		{
			$this->_config = IniConfig::getInstance();
			$this->_config->parseIniFile('database.ini');	
			$this->connectionDetails = $this->_config->get('database.' . $this->connectionName);
			$this->dsn = 
				$this->connectionDetails[$this->connectionName . '.driver'] . ':dbname=' .
				$this->connectionDetails[$this->connectionName . '.database'] . ';host=' .
				$this->connectionDetails[$this->connectionName . '.servername'] . ';';
			if(!empty($this->connectionDetails[$this->connectionName . '.port']))
				$this->dsn = $this->dsn . 'port=' . $this->connectionDetails[$this->connectionName . '.port'];
			$this->username = $this->connectionDetails[$this->connectionName . '.username'];
			$this->password = $this->connectionDetails[$this->connectionName . '.password'];
			
			// Let's try and connec to to database.
			parent::__construct($this->dsn, $this->username, $this->password);
			// Let's setup some error modes
			parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
	
	
	public function dbSelect($table, $fieldname = NULL, $id = NULL)
	{
		$this->stmt = $this->prepare("SELECT * FROM `$table` WHERE `$fieldname` = :id");
		$this->stmt->bindParam(':id', $id);
		$this->stmt->execute();

		return $this->stmp->fetchAll(PDO::FETCH_ASSOC);	
	}
	
	public function rawSelect($sql)
	{
		return $this->query($sql);
	}
	
	public function dbInsert($table, $values)
	{
		// Let's start prepare your query
		$fieldnames = array_keys($values[0]);
		// Let's build it
		$size = sizeof($fieldnames);
		$i = 1;
		// Now the actual sql
		$sql = "INSERT INTO `$table`";
		$fields = '(' . implode(' ,', $fieldnames) . ')';
		// Let's create your values
		$value = '(:' . implode(', :', $fieldnames) . ')';
		// Let's stick them
		$sql .= $fields . 'VALUES' . $value;
		
		// Let's prepare them and execute
		$this->stmt = $this->prepare($sql);
		foreach($values as $values)
		{
			$this->stmt->execute($values);
		}
	}
	
	public function dbUpdate($table, $fieldname, $value, $field, $id)
	{
		$this->stmt = $this->prepare("UPDATE `$table` SET `$fieldname` = '{$value}' WHERE `$field` = :id");
		$this->stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$this->stmt->execute();
	}
	
	public function dbDelete($table, $fieldname, $id)
	{
		$this->stmt = $this->prepare("DELETE FROM `$table` WHERE `$fieldname` = :id");
		$this->stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$this->stmt->execute();
	}
}
