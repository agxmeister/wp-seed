<?php

namespace Seed;

readonly class File
{
    public function __construct(private Http $http, private Storage $storage)
    {
    }

    public function getByUrl(string $url, string $fileName): string
    {
        $destinationPath = $this->storage->getPath($fileName);
        $this->http->download($url, $destinationPath);
        return $destinationPath;
    }
}
