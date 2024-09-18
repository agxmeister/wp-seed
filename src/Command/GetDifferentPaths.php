<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Monolog\Logger;
use Seed\Path;
use Seed\Utils;

readonly class GetDifferentPaths
{
    public function __construct(private Logger $logger, private Path $path, private Utils $utils)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        $this->logger->debug("Getting different paths", [$input]);
        [ , , $pathA, $pathB] = $input->args;
        $differentPaths = $this->utils->getDifferentPaths(
            $this->path->getStructure($pathA),
            $this->path->getStructure($pathB),
        );
        if (!in_array('--quiet', $input->flags)) {
            echo json_encode($differentPaths);
        }
        $this->logger->debug("Different paths are ", [$differentPaths]);
    }
}
