<?php

namespace Seed;

readonly class Destination
{
    public function __construct(private string $basePath)
    {
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }
}
