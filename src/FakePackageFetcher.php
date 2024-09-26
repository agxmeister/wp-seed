<?php

namespace Seed;

readonly class FakePackageFetcher implements PackageFetcher
{
    public function __construct(private Storage $storage)
    {
    }

    public function getByUrl(string $url, string $fileName): string
    {
        $destinationPath = $this->storage->getPath($fileName);
        file_put_contents($destinationPath, '');
        return $destinationPath;
    }
}
