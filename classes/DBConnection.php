<?php

/**
 * The DBConnector manages the connection to the Database, it is developed with the singletonpattern to make sure that
 * only one instance is running on this server.
 * The Connector is supposed to use prepared statements, to protect the database from sql injections.
 **/
class DBConnection
{
    /**
     * The following data represents the Database login, please make sure that you don't use ROOT ACCESS!!!
     */
    private $server;
    private $database = array();
	private $parametersDB;
    /**
     * The conn variable holds the activ connection to the Database.
     */
    private $conn = null;
    private static $me = null;

    /**
     * The Constructor creates the activ connection to the Database and tests the connection,
     * if it fails it will output a error message.
     **/
    protected function __construct()
    {
        $dbConfig = getConfig();
        
        $this->server = $dbConfig["server"];
        $this->database = $dbConfig["database"];

		// connects the database and returns sql errors if no conncetion was established
        $this->conn = sqlsrv_connect($this->server,$this->database);;
        if (!$this->conn)
		{
			die(print_r(sqlsrv_errors(),true));
		}
		
    }
    /**
     * This function returns the instance of the DBConnector, if there is no activ instance it will create a new one.
     * @return DBConnection object which represents the connection to a MySQL Server.
     **/
    public static function getInstance()
    {
        if (self::$me === null) {
            self::$me = new DBConnection();
        }
        return self::$me;
    }
    /**
     * This function will be called by the Garbagecollector and will close the connection.
     */
    public function __destruct()
    {
        sqlsrv_close($this->conn);
    }

    /**
     * This function will execute a SQL-Query and return the result and is supposed to use for SELECT statements.
     * @param string $query
     * @return string
     * @internal param string $query The Query that needs to be executed at the database.
     */
    public function executeQuery($query)
    {
		$result= sqlsrv_query($this->conn, $query);
		$this->checkSQLErrors($result);
		return $result;
    }
	/**
     * This function will execute a prepared SQL-Query and is supposed to use for INSERT statements.
     * @param string query 
     * @param array parameters 
     */
	public function executeQueryPrepared($query,$parameters)
	{
		/* 
		** creates and executes a prepared statement
		**/
		if($stmt = sqlsrv_prepare($this->conn, $query, $parameters))
		{
			echo 'Statement prepared </br>';
		}
		else
		{
			die ('Statement not prepared');
		}
		
		/*
		** executes the prepared statement and 
		*/
		if($inspectValue=sqlsrv_execute($stmt))
		{
			$this->checkSQLErrors($inspectValue);
			echo 'Statement executet </br>';
		}
		else
		{
			die ('Statement not executet');
		}
		//check for potential sql errors
		
	}
	// one uses the following code, to many times to check if an SQL query has any erros. so i wrote a function
	public function checkSQLErrors($checkValue)
	{
		if (!$checkValue)
		{
			echo 'die Eingabe war fehlerhaft, bitte nehmen sie eine erneute Eingabe vor';
			echo '</br>';
			die(print_r(sqlsrv_errors(),true));
		}
	}

    /*
	** This function is there to prevent to create another instance of the DBConnector, if someone trys to clone the instance it will fail.
	*/
    protected function __clone()
    {
    }
	
	/*
	** this function transforms the query to an assiciative array, which i use for the most part to retrive Data from the Database
	*/
	public function sqlToAssocArray($query)
	{
		$result= $this->executeQuery($query);
		while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
		{
			$AssocArray[]= $row; 
		}
		if($AssocArray!= NULL)
		{
			return $AssocArray;
		}	
		else
		{
			die("keine Rückgabe");
		}
	}
	
}
