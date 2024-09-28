<?php

namespace Seed;

use GuzzleHttp\Client;

class GuzzleHttp implements Downloader
{
    public function download(string $url, string $path): void
    {
        $guzzle = new Client();
        $guzzle->get($url, ['sink' => $path]);
    }
}
