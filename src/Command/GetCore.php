<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\Fetcher;
use Seed\PackageType;

readonly class GetCore
{
    public function __construct(private Logger $logger, private Fetcher $fetcher)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Download WordPress core...", [$input]);
        $filename = $input->params['--filename'] ?? null;
        $version = $input->params['--version'] ?? null;
        $this->logger->debug("Use version...", [$version ?? 'latest']);
        $type = $input->params['--type'] ?? null;
        $this->fetcher->getCore(
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
