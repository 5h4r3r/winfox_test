<?php

namespace App;

class Database
{

    private $host = "192.168.0.117";
    private $port = 5432;
    private $dbname = 'winfox';
    private $username = 'winfox';
    private $password = 'winfox';
    private $options = [];
    public $conn;

    public function getConnection()
    {

        $this->conn = null;

        $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbname;

        try {
            $this->conn = new \PDO($dsn, $this->username, $this->password, $this->options);
            $this->conn->exec("set names utf8");
        } catch (\PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
