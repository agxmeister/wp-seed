<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\Destination;
use Seed\Model\Database;
use Seed\Model\DatabaseUser;
use Seed\Mysql;
use Seed\Package;

readonly class InstallPackage
{
    public function __construct(
        private Logger $logger,
        private Package $package,
        private Destination $destination,
        private Mysql $mysql,
    )
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Unpack WordPress", [$input]);

        $name = $input->params['--name'] ?? null;
        $corePackagePath = $input->params['--package-path'] ?? null;
        $databaseDumpPath = $input->params['--database-dump-path'] ?? null;

        $isCleanup = in_array('--cleanup', $input->flags);
        $destinationPath = $this->destination->getSitePath($name);
        if ($isCleanup) {
            $this->destination->cleanup($name);
        }
        $this->package->extract($corePackagePath, $destinationPath);
        $this->destination->move($name);
        $this->destination->configure($name, $name, $name, $name, 'mysql');

        $this->mysql->createDatabase(new Database($name), new DatabaseUser($name, $name, '%'));
        $this->mysql->restoreDatabaseDump(new Database($name), $databaseDumpPath);

        $this->logger->debug("WordPress unpacked to ", [$destinationPath]);
    }
}
