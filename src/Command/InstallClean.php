<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\Destination;
use Seed\Model\Database;
use Seed\Model\DatabaseUser;
use Seed\Mysql;
use Seed\Package;
use Seed\WpCli;

readonly class InstallClean
{
    public function __construct(
        private Logger $logger,
        private Package $package,
        private Destination $destination,
        private Mysql $mysql,
        private WpCli $wpCli,
    )
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Install WordPress", [$input]);
        $name = $input->params['--name'] ?? null;
        $version = $input->params['--version'] ?? null;
        $isCleanup = in_array('--cleanup', $input->flags);
        $corePackagePath = $this->package->getCore($version);
        $destinationPath = $this->destination->getSitePath($name);
        if ($isCleanup) {
            $this->destination->cleanup($name);
        }
        $this->package->extract($corePackagePath, $destinationPath);
        $this->destination->move($name);
        $this->destination->configure($name, $name, $name, $name, 'mysql');
        $this->mysql->createDatabase(new Database($name), new DatabaseUser($name, $name, '%'));
        $this->wpCli->run($name, "core install --url=example.com --title=mysite --admin_user=admin --admin_email=admin@example.com --allow-root");
        $this->logger->debug("WordPress installed to ", [$destinationPath]);
    }
}
