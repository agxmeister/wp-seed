<?php

namespace Seed\Model;

readonly class DatabaseUser
{
    public function __construct(public string $name, public string $password, public string $host)
    {
    }
}
