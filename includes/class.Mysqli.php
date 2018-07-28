<?php

class MySQLiDatabase
{
    private $connection;
    public  $last_query;

    function __construct()
    {
        $this->open_connection();
    }

    public function open_connection()
    {
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if (!$this->connection) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
    }

    public function close_connection()
    {
        if (isset($this->connection))
        {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    public function query($sql)
    {
        $this->last_query = $sql;
        $result = mysqli_query($this->connection, $sql);
        $this->confirm_query($result);
        return $result;
    }

    public function escape_value($value)
    {
        $value = mysqli_real_escape_string($this->connection,$value);
        return $value;
    }

    public function fetch_array($result_set)
    {
        return mysqli_fetch_array($result_set);
    }

    public function fetch_array_assoc($result_set)
    {
        return mysqli_fetch_assoc($result_set);
    }

    public function num_rows($result_set)
    {
        return mysqli_num_rows($result_set);
    }

    public function insert_id()
    {
        return mysqli_insert_id($this->connection);
    }

    public function affected_rows()
    {
        return mysqli_affected_rows($this->connection);
    }

    private function confirm_query($result)
    {
        if (!$result)
        {
            $output = "Database query failed: " . mysqli_error($this->connection) . "<br /><br />";
            $output .= "Last SQL query: " . $this->last_query;
            die($output);
        }
    }

    public function startTransaction()
    {
        mysqli_begin_transaction($this->connection, MYSQLI_TRANS_START_READ_WRITE);
    }

    public function commitTransaction()
    {
        mysqli_commit($this->connection);
    }
}

$database = new MySQLiDatabase();
$db = & $database;
