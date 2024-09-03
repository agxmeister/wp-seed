<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;

readonly class GetDifferentPaths
{
    public function __construct(private Logger $logger)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Getting different paths", [$input]);
    }
}
