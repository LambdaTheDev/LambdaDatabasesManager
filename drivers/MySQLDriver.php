<?php


class MySQLDriver //todo: Get all needed methods & setup IDriver interface
{
    private string $host;
    private string $username;
    private string $password;
    private ?string $database;

    private PDO $driver;

    public function __construct(array $data)
    {
        if(!array_key_exists('host', $data) || !array_key_exists('username', $data) || !array_key_exists('password', $data))
        {
            throw new InvalidConnectionException("Not all required data were provided!");
        }

        $this->host = $data['host'];
        $this->username = $data['username'];
        $this->password = $data['password'];

        if(array_key_exists('database', $data))
        {
            $this->database = $data['database'];
        }

        $this->initialize();
    }

    private function initialize()
    {
        $connStr = 'mysql:host=' . $this->host;
        if($this->database != null) $connStr .= ';dbname=' . $this->database;

        $this->driver = new PDO($connStr, $this->username, $this->password);
    }

    public function sqlQuery(string $strQuery) : int
    {
        $query = $this->driver->query($strQuery);
        return intval($this->driver->errorCode());
    }

    public function selectDatabases() : array
    {
        $query = $this->driver->query("SHOW DATABASES;");
        return $query->fetchAll();
    }

    public function createDatabase(string $name) : bool
    {
        return $this->driver->query("CREATE DATABASE " . addslashes($name) . ";");
    }

    public function dropDatabase(string $name) : bool
    {
        return $this->driver->query("DROP DATABASE IF EXISTS " . addslashes($name) . ';');
    }

    public function selectTables(string $targetDatabase) : array
    {
        $targetDatabase = addslashes($targetDatabase);

        $result = array();
        $query = $this->driver->query("SHOW TABLES FROM " . $targetDatabase . ';');
        while ($table = $query->fetch(PDO::FETCH_ASSOC))
        {
            $tableName = $table['Tables_in_' . $targetDatabase];
            array_push($result, $tableName);
        }

        return $result;
    }

    public function createTable(string $targetDatabase, string $name, array $columns) : bool
    {
        $targetDatabase = addslashes($targetDatabase);
        $name = addslashes($name);

        $strQuery = "CREATE TABLE " . $name . "(";
        foreach ($columns as $column)
        {

        }
    }

    public function dropTable(string $targetDatabase, string $targetTable)
    {
    }

    public function selectRows(string $targetDatabase, string $targetTable) : array
    {
        $targetDatabase = addslashes($targetDatabase);
        $targetTable = addslashes($targetTable);

        $result = array();
        $this->driver->query("USE " . $targetDatabase);
        $query = $this->driver->query("SELECT * FROM " . $targetTable . ";");
        while ($row = $query->fetch(PDO::FETCH_ASSOC))
        {
            array_push($result, $row);
        }

        return $result;
    }
}