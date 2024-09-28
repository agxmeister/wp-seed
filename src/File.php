<?php

namespace Seed;

readonly class File
{
    public function __construct(private Downloader $downloader, private Storage $storage)
    {
    }

    public function getByUrl(string $url, string $fileName): string
    {
        $destinationPath = $this->storage->getPath($fileName);
        $this->downloader->download($url, $destinationPath);
        return $destinationPath;
    }
}
