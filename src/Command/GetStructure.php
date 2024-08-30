<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;
use Seed\Path;

readonly class GetStructure
{
    public function __invoke(CommandCall $input): void
    {
        [ , , $pathArg] = $input->args;
        $path = new Path();
        $structure = $path->getStructure($pathArg);
        var_dump($structure);
    }
}
