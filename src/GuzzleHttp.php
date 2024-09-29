<?php

namespace Seed;

use GuzzleHttp\Client;

readonly class GuzzleHttp implements Downloader
{
    public function __construct(private Client $client)
    {
    }

    public function download(string $url, string $path): void
    {
        $this->client->get($url, ['sink' => $path]);
    }
}
