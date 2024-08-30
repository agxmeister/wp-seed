<?php

namespace Seed\Command;

use Minicli\Command\CommandCall;

readonly class GetDifferentPaths
{
    public function __invoke(CommandCall $input): void
    {
        var_dump($input);
    }
}
