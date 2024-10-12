<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\Package;
use Seed\PackageType;
use function DI\value;

readonly class GetCore
{
    public function __construct(private Logger $logger, private Package $package)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Download WordPress core...", [$input]);
        $filename = $input->params['--filename'] ?? null;
        $version = $input->params['--version'] ?? null;
        $this->logger->debug("Use version...", [$version ?? 'latest']);
        $type = $input->params['--type'] ?? null;
        $this->package->getCore(
            $version,
            $filename,
            array_reduce(
                PackageType::cases(),
                fn($acc, PackageType $case) => $case->value === $type ? $case : $acc,
            ),
        );
        $this->logger->debug("WordPress core downloaded", [$filename]);
    }
}
