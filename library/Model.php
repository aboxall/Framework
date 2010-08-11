<?php
class Model extends PDO
{
    protected $_config;
    private $connectionDetails, $dsn, $username, $password, $table, $values;
    public function __construct ()
    {
        try {
            $this->_config = IniConfig::getInstance();
            $this->_config->parseIniFile(
            'database.ini');
            $this->connectionDetails = $this->_config->get(
            'database.' . $this->connectionName);
            $this->dsn = $this->connectionDetails[$this->connectionName .
             '.driver'] . ':dbname=' .
             $this->connectionDetails[$this->connectionName .
             '.database'] . ';host=' .
             $this->connectionDetails[$this->connectionName .
             '.servername'] . ';';
            if (! empty(
            $this->connectionDetails[$this->connectionName .
             '.port']))
                $this->dsn = $this->dsn .
                 'port=' .
                 $this->connectionDetails[$this->connectionName .
                 '.port'];
            $this->username = $this->connectionDetails[$this->connectionName .
             '.username'];
            $this->password = $this->connectionDetails[$this->connectionName .
             '.password'];
            // Let's try and connec to to database.
            parent::__construct(
            $this->dsn, 
            $this->username, 
            $this->password);
            // Let's setup some error modes
            parent::setAttribute(
            PDO::ATTR_ERRMODE, 
            PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function Select ($table, $fieldname = NULL, $id = NULL)
    {
        $this->stmt = $this->prepare(
        "SELECT * FROM `$table` WHERE `$fieldname` = :id");
        $this->stmt->bindParam(':id', $id);
        $this->stmt->execute();
        return $this->stmp->fetchAll(
        PDO::FETCH_ASSOC);
    }
    public function Update ($table, $fieldname, $value, $field, 
    $id)
    {
        $this->stmt = $this->prepare(
        "UPDATE `$table` SET `$fieldname` = '{$value}' WHERE `$field` = :id");
        $this->stmt->bindParam(':id', $id, 
        PDO::PARAM_STR);
        $this->stmt->execute();
    }
    public function Insert ($insert)
    {
        // loop through the data for each table
        foreach ($insert as $table => $data) {
            // ensure we're not tryingt to insert empty data
            if (sizeof(
            $data) == 0) {
                continue;
            }
            // start building up SQL
            $sql = "INSERT INTO `$table` ";
            // check if field names were passed
            if ($this->is_assoc_array(
            $data[0])) {
                // add field names to SQL
                $sql .= "(" .
                 implode(
                ", ", 
                array_keys(
                $data[0])) .
                 ") ";
            }
            $sql .= 'VALUES ';
            // add question mark place holders
            $holders = array_fill(
            0, sizeof($data[0]), 
            '?');
            $sql .= "(" . implode(
            ", ", $holders) . ");";
            // prepare statement
            $stmt = $this->prepare(
            $sql);
            // loop through each row
            foreach ($data as $row) {
                // place holder index
                $ph = 1;
                // loop through each value
                foreach ($row as $value) {
                    // bind value
                    $stmt->bindValue(
                    $ph, 
                    $value);
                    // increment place holder index
                    $ph ++;
                }
                try {
                    // execute statement
                    $stmt->execute();
                } catch (PDOException $e) {
                    // handle error better than this
                    exit(
                    $e->getMessage());
                }
            }
        }
    }
    public function Delete ($table, $fieldname, $id)
    {
        $this->stmt = $this->prepare(
        "DELETE FROM `$table` WHERE `$fieldname` = :id");
        $this->stmt->bindParam(':id', $id, 
        PDO::PARAM_STR);
        $this->stmt->execute();
    }
    public function implodeValues ($array)
    {
        return '(:' . implode(', :', $array) . ')';
    }
}