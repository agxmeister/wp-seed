<?php

namespace Seed;

readonly class Storage
{
    public function __construct(private string $basePath)
    {
    }

    public function getPath(string $fileName): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . $fileName;
    }
}
