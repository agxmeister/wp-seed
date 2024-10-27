<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\WpCli;

readonly class WpCliGate
{
    public function __construct(private Logger $logger, private WpCli $wpCli)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Run WP-CLI command", [$input]);
        $name = $input->params['--name'] ?? null;
        $command = $input->params['--command'] ?? null;
        $output = $this->wpCli->run($name, $command);
        $this->logger->debug("Output is ", [$output]);
    }
}
