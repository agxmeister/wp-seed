<?php

namespace Seed;

readonly class WpCli
{
    public function __construct(private Tools $tools, private Destination $destination)
    {
    }

    public function run($name, $command): array
    {
        exec($this->tools->getWpCliPath() . ' --path="' . $this->destination->getSitePath($name) . '" ' . $command . ' 2>&1', $output);
        return $output;
    }
}
