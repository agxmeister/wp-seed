<?php

namespace Seed;

use mysqli;

readonly class Mysql
{
    private mysqli $connection;

    public function __construct(private ?string $host, private ?int $port, private ?string $username, private ?string $password)
    {
    }

    public function createDatabase(string $database): void
    {
        $this->getConnection()->query("CREATE DATABASE `$database`");
    }

    public function createDatabaseUser(string $username, string $password, string $database): void
    {
        $connection = $this->getConnection();
        $connection->query("CREATE USER '$username'@'localhost' IDENTIFIED BY '$password'");
        $connection->query("GRANT ALL ON `$database`.* TO '$username'@'localhost'");
    }

    private function getConnection(): mysqli
    {
        if (!isset($this->connection)) {
            $this->connection = new mysqli($this->host, $this->username, $this->password, null, $this->port, null);
        }
        return $this->connection;
    }
}
