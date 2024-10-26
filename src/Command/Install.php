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
        $name = $input->params['--name'] ?? null;
        $version = $input->params['--version'] ?? null;
        $isCleanup = in_array('--cleanup', $input->flags);
        $corePackagePath = $this->package->getCore($version);
        $destinationPath = $this->destination->getWebPath($name);
        if ($isCleanup) {
            $this->destination->cleanup($name);
        }
        $this->package->extract($corePackagePath, $destinationPath);
        $this->destination->move($name);
        $this->destination->configure($name, 'test', 'test', 'test');
        $this->logger->debug("WordPress installed to ", [$destinationPath]);
    }
}
