<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\Model\Database;
use Seed\Mysql;

readonly class GetDatabaseDump
{
    public function __construct(private Logger $logger, private Mysql $mysql)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Get database dump", [$input]);
        $database = $input->params['--database'] ?? null;
        $outputFilePath = $input->params['--out'] ?? null;
        $databaseDump = $this->mysql->getDatabaseDump(new Database($database));
        if (!is_null($outputFilePath)) {
            file_put_contents($outputFilePath, $databaseDump);
        } else {
            echo $databaseDump;
        }
        $this->logger->debug("Database created", [$database]);
    }
}
