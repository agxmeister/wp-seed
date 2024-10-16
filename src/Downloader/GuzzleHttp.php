<?php

namespace Seed\Downloader;

use GuzzleHttp\Client as GuzzleHttpClient;

readonly class GuzzleHttp implements Downloader
{
    public function __construct(private GuzzleHttpClient $client)
    {
    }

    public function download(string $url, string $path): void
    {
        $this->client->get($url, [
            'sink' => $path,
            'headers' => [
                'user-agent' => 'WpSeed/1.0',
            ],
        ]);
    }
}
