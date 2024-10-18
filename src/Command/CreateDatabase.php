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
        $this->logger->debug("Extract the package", [$input]);
        $database = $input->params['--database'] ?? null;
        $this->mysql->createDatabase($database);
        $this->logger->debug("Database created", [$database]);
    }
}
