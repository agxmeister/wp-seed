<?php

namespace Seed;

readonly class Destination
{
    public function __construct(private string $basePath)
    {
    }

    public function getSitePath($name): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . $name;
    }
}
