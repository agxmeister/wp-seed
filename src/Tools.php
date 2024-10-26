<?php

namespace Seed;

readonly class Tools
{
    public function __construct(private string $basePath)
    {
    }

    public function getWpCliPath(): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'wp-cli.phar';
    }
}
