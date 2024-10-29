<?php

namespace Seed;

use mysqli;
use Seed\Model\Database;
use Seed\Model\DatabaseUser;

readonly class Mysql
{
    private mysqli $connection;

    public function __construct(private ?string $host, private ?int $port, private ?string $username, private ?string $password)
    {
    }

    public function createDatabase(Database $database, ?DatabaseUser $user): void
    {
        $connection = $this->getConnection();
        $connection->begin_transaction();
        $connection->query("DROP DATABASE IF EXISTS `$database->name`");
        $connection->query("CREATE DATABASE `$database->name`");
        if (!is_null($user)) {
            $connection->query("DROP USER IF EXISTS `$user->name`");
            $connection->query("CREATE USER '$user->name'@'$user->host' IDENTIFIED BY '$user->password'");
            $connection->query("GRANT ALL ON `$database->name`.* TO '$user->name'@'$user->host'");
        }
        $connection->commit();
    }

    private function getConnection(): mysqli
    {
        if (!isset($this->connection)) {
            $this->connection = new mysqli($this->host, $this->username, $this->password, null, $this->port, null);
        }
        return $this->connection;
    }
}
