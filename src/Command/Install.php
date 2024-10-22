<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\Destination;
use Seed\Package;

readonly class Install
{
    public function __construct(private Logger $logger, private Package $package, private Destination $destination)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Install WordPress", [$input]);
        $version = $input->params['--version'] ?? null;
        $cleanup = in_array('--cleanup', $input->flags);
        $corePackagePath = $this->package->getCore($version);
        $destinationPath = $this->destination->getBasePath();
        if ($cleanup) {
            $this->destination->cleanup('.');
        }
        $this->package->extract($corePackagePath, $destinationPath);
        $this->logger->debug("WordPress installed to ", [$destinationPath]);
    }
}
