<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\Model\Database;
use Seed\Mysql;

readonly class RestoreDatabaseDump
{
    public function __construct(private Logger $logger, private Mysql $mysql)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Restore database dump", [$input]);
        $database = $input->params['--database'] ?? null;
        $dumpFilePath = $input->params['--in'] ?? null;
        $this->mysql->restoreDatabaseDump(new Database($database), $dumpFilePath);
        $this->logger->debug("Database restored", [$database]);
    }
}
