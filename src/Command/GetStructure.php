<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\Path;

readonly class GetStructure
{
    public function __construct(private Logger $logger, private Path $path)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Getting structure", [$input]);
        [ , , $pathArg] = $input->args;
        $structure = $this->path->getStructure($pathArg);
        if (!in_array('--quiet', $input->flags)) {
            echo json_encode($structure);
        }
        $this->logger->debug("Structure is ", [$structure]);
    }
}
