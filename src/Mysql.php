<?php

namespace Seed;

readonly class Mysql
{
    public function __construct(private ?string $host, private ?int $port, private ?string $username, private ?string $password)
    {
    }

    public function createDatabase(string $database): void
    {
        $client = mysqli_connect($this->host, $this->username, $this->password, null, $this->port, null);
        $client->query("CREATE DATABASE IF NOT EXISTS $database");
    }
}
