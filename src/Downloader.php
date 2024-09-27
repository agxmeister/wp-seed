<?php

namespace Seed;

interface Downloader
{
    public function download(string $url, string $path): void;
}
