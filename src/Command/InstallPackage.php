<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\Farm;
use Seed\Model\Database;
use Seed\Model\DatabaseUser;
use Seed\Mysql;
use Seed\Package;
use Seed\Profiler;

readonly class InstallPackage
{
    public function __construct(
        private Logger $logger,
        private Profiler $profiler,
        private Package $package,
        private Farm $farm,
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
        $destinationPath = $this->farm->getSitePath($name);
        if ($isCleanup) {
            $this->profiler->check('cleanup');
            $this->farm->cleanup($name);
        }
        $this->profiler->check('extract');
        $this->package->extract($corePackagePath, $destinationPath, $this->package::TYPE_TAR);
        $this->profiler->check('move');
        $this->farm->move($name);
        $this->profiler->check('configure');
        $this->farm->configure($name, $name, $name, $name, 'mysql');

        $this->profiler->check('create-database');
        $this->mysql->createDatabase(new Database($name), new DatabaseUser($name, $name, '%'));
        $this->profiler->check('restore-database-dump');
        $this->mysql->restoreDatabaseDump(new Database($name), $databaseDumpPath);
        $this->profiler->dump('./profile-package.json');

        $this->logger->debug("WordPress unpacked to ", [$destinationPath]);
    }
}
