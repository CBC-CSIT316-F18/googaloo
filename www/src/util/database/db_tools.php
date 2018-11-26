<?php
namespace src\util\database\db_tools;


use mysqli;

class db_tools
{
    /** @var mysqli $connection */
    public $connection=null;
    public $rows=null;
    public $username="root";
    public $password="";
    public $dbname="charter";

    /**
     * @return \mysqli|null|string
     */
    function db_connect()
    {
        // Define connection as a static variable, to avoid connecting more than once
        // Try and connect to the database, if a connection has not been established yet
        if(!isset($this->connection))
        {
                    // Load configuration as an array. Use the actual location of your configuration file
                    // Put the configuration file outside of the document root
            //$config = parse_ini_file(CONFIG);
            $this->connection = mysqli_connect('localhost',$this->username,$this->password,$this->dbname);
        }
        // If connection was not successful, handle the error
        if($this->connection === false) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
            return "error";
        }
        return $this->connection;
    }

    /**
     * @param $query
     * @return bool|\mysqli_result
     */
    function db_query($query)
    {
        // Connect to the database
        $this->db_connect();
        // Query the database
        $result = mysqli_query($this->connection,$query);
        return $result;
    }

    /**
     * @param string $query
     * @return array|bool
     */
    function db_select($query)
    {
        $rows = array();
        $result = $this->db_query($query);

        // If query failed, return `false`
        if($result === false) {
            return false;
        }
        // If query was successful, retrieve all the rows into an array
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * @return string
     */
    function db_error()
    {
        $this->db_connect();
        return mysqli_error($this->connection);
    }

    /**
     * @param string $value
     * @return string
     */
    function db_quote($value)
    {
        $this->db_connect();
        return "'" . mysqli_real_escape_string($this->connection,$value) . "'";
    }

    public function escape_data ($data) {

        // Strip the slashes if Magic Quotes is on:
        if (get_magic_quotes_gpc()) $data = stripslashes($data);
        // Apply trim() and mysqli_real_escape_string():
        return mysqli_real_escape_string ($this->connection, trim ($data));
    } // End of the escape_data() function.


    /**
     * Uses mysqi interface to safely use strings.
     * @param String $string String to make safe
     * @return String
     */
    function escapeStringForDBUse($string)
    {
        return $this->connection->real_escape_string($string);
    }
}

