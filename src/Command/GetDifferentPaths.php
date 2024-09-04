<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\Utils;

readonly class GetDifferentPaths
{
    public function __construct(private Logger $logger, private Utils $utils)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Getting different paths", [$input]);
        [ , , $pathA, $pathB] = $input->args;
        $differentPaths = $this->utils->getDifferentPaths($pathA, $pathB);
        $this->logger->debug("Different paths are ", [$differentPaths]);
    }
}
