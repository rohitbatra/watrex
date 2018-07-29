<?php

class Db2Database
{
    private $connectionStr;
    private $connection;
    public  $last_query;

    function __construct() {

        $this->connectionStr  =
                    "DRIVER={".Db2Config::DB_DRIVER."};".
                    "DATABASE=".Db2Config::DB_NAME."; " .
                    "HOSTNAME=".Db2Config::DB_HOST.";" .
                    "SYSTEM=".Db2Config::DB_HOST.";" .
                    "PORT=".Db2Config::DB_PORT."; " .
                    "PROTOCOL=TCPIP; " .
                    "UID=".Db2Config::DB_USER.";" .
                    "PWD=".Db2Config::DB_PASS.";";

        $this->open_connection();
    }


    public function open_connection() {

        $this->connection = odbc_connect($this->connectionStr,"","");
        if (!$this->connection) {
            echo "Error: Unable to connect to IBM DB2." . PHP_EOL;
            echo "Error No: " . odbc_error($this->connection) . PHP_EOL;
            echo "Error Msg: " . odbc_errormsg($this->connection) . PHP_EOL;
            exit;
        }
    }

    public function close_connection() {

        if (isset($this->connection)) {
            odbc_close($this->connection);
            unset($this->connection);
        }
    }

    public function query($sql) {

        $this->last_query = $sql;
        $result = odbc_exec($this->connection, $sql);
        $this->confirm_query($result);
        return $result;
    }

    public function fetch_array_assoc($result_set) {
        return odbc_fetch_array($result_set);
    }

    public function num_rows($result_set) {
        return odbc_num_rows($result_set);
    }

    private function confirm_query($result) {
        if (!$result) {
            $output =  "Database query failed: " . odbc_errormsg($this->connection) . PHP_EOL;
            $output .= "Last SQL query: " . $this->last_query;
            die($output);
        }
    }

    public function fetch_all_array_assoc($result_set) {
        $retArr = array();
        while($row = odbc_fetch_array($result_set)) {
            $retArr[] = $row;
        }
        return $retArr;
    }

}

$db2Database = new Db2Database();
$db2 = & $db2Database;