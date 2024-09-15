<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\Package;

readonly class Extract
{
    public function __construct(private Logger $logger, private Package $package)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Extract the package", [$input]);
        [ , , $sourcePath, $destinationPath] = $input->args;
        $type = $input->params['--type'] ?? null;
        $this->package->extract($sourcePath, $destinationPath, $type);
        $this->logger->debug("The package extracted to ", [$destinationPath]);
    }
}
