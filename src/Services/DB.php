<?php declare(strict_types=1);

namespace App\Services;

class DB
{
    public $connection = null;
    public $error = false;

    private function checkConnection()
    {
        if ($this->connection === null) {
            $this->connect();
        }
    }

    public function connect(string $configSetIdent = "NWOUN")
    {
        $servername = $_ENV['MYSQL_SERVERNAME_' . $configSetIdent];
        $username = $_ENV['MYSQL_USERNAME_' . $configSetIdent];
        $password = $_ENV['MYSQL_PASSWORD_' . $configSetIdent];
        try {
            $this->connection = new \mysqli($servername, $username, $password);
        } catch (\Exception $e) {
            $this->error = true;
        }

        // Check connection
        if ($this->connection->connect_error) {
            $this->error = true;
        } else {
            $this->connection->select_db($_ENV['MYSQL_DB_' . $configSetIdent]);
            $this->connection->query('SET NAMES utf8');
        }
    }

    public function escape(string $s)
    {
        $this->checkConnection();
        return $this->connection->real_escape_string($s);
    }

    /**
     * simple function that queries the db and returns the results array
     *
     * @param String $query
     *
     * @return Array
     */
    public function sql_fetch_array(string $query): array
    {
        $this->checkConnection();
        $result = $this->connection->query($query);
        $results_ary = array();
        while ($row = $result->fetch_array()) {
            $results_ary[] = $row;
        }

        return $results_ary;
    }

    public function query(string $sql)
    {
        $this->checkConnection();
        return $this->connection->query($sql);
    }
}
