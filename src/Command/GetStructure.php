<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Seed\Path;

readonly class GetStructure
{
    public function __construct(private Path $path)
    {
    }

    public function __invoke(CommandCall $input): void
    {
        [ , , $pathArg] = $input->args;
        $structure = $this->path->getStructure($pathArg);
        var_dump($structure);
    }
}
