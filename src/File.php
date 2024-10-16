<?php

namespace Seed;

use Seed\Downloader\Downloader;

readonly class File
{
    public function __construct(private Downloader $downloader)
    {
    }

    public function getByUrl(string $url, string $destinationPath): void
    {
        $this->downloader->download($url, $destinationPath);
    }
}
