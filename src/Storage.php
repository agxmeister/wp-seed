<?php

namespace Seed;

readonly class Storage
{
    public function __construct(private string $basePath)
    {
    }

    public function getPackagePath(string $name): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . $name;
    }
}
