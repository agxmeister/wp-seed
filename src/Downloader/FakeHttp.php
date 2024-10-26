<?php

namespace Seed\Downloader;

readonly class FakeHttp implements Downloader
{
    public function download(string $url, string $path): void
    {
        file_put_contents($path, '');
    }
}