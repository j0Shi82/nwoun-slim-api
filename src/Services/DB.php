<?php declare(strict_types=1);

namespace App\Services;

class DB
{
    public $connection = null;
    public $error = false;

    public function __construct()
    {
        $servername = $_ENV['MYSQL_SERVERNAME'];
        $username = $_ENV['MYSQL_USERNAME'];
        $password = $_ENV['MYSQL_PASSWORD'];
        try {
            $this->connection = new \mysqli($servername, $username, $password);
        } catch (Exception $e) {
            $this->error = true;
        }

        // Check connection
        if ($conn->connect_error) {
            $this->error = true;
        } else {
            $this->connection->select_db($_ENV['MYSQL_DB']);
            $this->connection->query('SET NAMES utf8');
        }
    }

    public function escape(String $s)
    {
        return $this->connection->real_escape_string($s);
    }

    /**
     * simple function that queries the db and returns the results array
     *
     * @param String $query
     *
     * @return Array
     */
    public function sql_fetch_array(String $query)
    {
        $result = $this->connection->query($query);
        $results_ary = array();
        while ($row = $result->fetch_array()) {
            $results_ary[] = $row;
        }

        return $results_ary;
    }
}
