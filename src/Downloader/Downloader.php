<?php

namespace Seed\Downloader;

interface Downloader
{
    public function download(string $url, string $path): void;
}
