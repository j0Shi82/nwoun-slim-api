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
        $this->connection = new \mysqli($servername, $username, $password);

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
}
