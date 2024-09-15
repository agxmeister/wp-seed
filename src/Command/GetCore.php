<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\Package;

readonly class GetCore
{
    public function __construct(private Logger $logger, private Package $package)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Download the latest WordPress core", [$input]);
        [ , , $pathArg] = $input->args;
        $version = $input->params['version'] ?? null;
        $this->package->getCore($pathArg, $version);
        $this->logger->debug("The latest WordPress core downloaded to ", [$pathArg]);
    }
}