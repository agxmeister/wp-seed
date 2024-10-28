<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\Mysql;

readonly class CreateDatabase
{
    public function __construct(private Logger $logger, private Mysql $mysql)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Create database", [$input]);
        $database = $input->params['--database'] ?? null;
        $username = $input->params['--username'] ?? null;
        $password = $input->params['--password'] ?? null;
        $hostname = $input->params['--hostname'] ?? null;
        $this->mysql->createDatabase($database);
        $this->logger->debug("Database created", [$database]);
        if (!is_null($username) && !is_null($password)) {
            $this->mysql->createDatabaseUser($database, $username, $password, $hostname);
            $this->logger->debug("Database user created", [$username]);
        }
    }
}
