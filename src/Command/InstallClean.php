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
use Seed\WpCli;

readonly class InstallClean
{
    public function __construct(
        private Logger $logger,
        private Profiler $profiler,
        private Package $package,
        private Farm $farm,
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
        $cleanup = in_array('--cleanup', $input->flags);

        $this->profiler->check('deploy');
        $this->farm->deploy($name, $version, $cleanup);
        $this->profiler->check('configure');
        $this->farm->configure($name, $name, $name, $name, 'mysql');
        $this->profiler->check('create-database');
        $this->mysql->createDatabase(new Database($name), new DatabaseUser($name, $name, '%'));
        $this->profiler->check('install-core');
        $this->wpCli->run($name, "core install --url=example.com --title=mysite --admin_user=admin --admin_email=admin@example.com --allow-root");
        $this->profiler->dump('./profile-clean.json');

        $this->logger->debug("WordPress installed to ", [$this->farm->getSitePath($name)]);
    }
}
