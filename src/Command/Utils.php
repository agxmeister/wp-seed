<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\WpCli;

readonly class Utils
{
    public function __construct(private Logger $logger, private WpCli $wpCli)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $handler = match ($input->subcommand) {
            'install-wp-cli' => fn() => $this->installWpCli(),
        };
        $handler();
    }

    private function installWpCli(): void
    {
        $this->logger->debug("Install WP-CLI");
        $this->wpCli->install();
        $this->logger->debug("WP CLI installed");
    }
}
