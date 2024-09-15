<?php

namespace Seed;

use PharData;
use ZipArchive;

class Package
{
    const string TYPE_ZIP = 'zip';
    const string TYPE_GZIP = 'gzip';

    const string BASE_URL_CORE = 'https://wordpress.org';

    public function getCore(string $destinationPath, string $version = null): void
    {
        $url = self::BASE_URL_CORE . '/' . (is_null($version) ? 'latest' : 'wordpress-' . $version) . '.tar.gz';
        $curl = curl_init($url);
        $file = fopen($destinationPath, 'wb');
        curl_setopt($curl, CURLOPT_FILE, $file);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_exec($curl);
        curl_close($curl);
        fclose($file);
    }

    public function extract(string $sourcePath, string $destinationPath, $type = self::TYPE_ZIP): void
    {
        $handler = match($type) {
            self::TYPE_ZIP => function () use ($sourcePath, $destinationPath) {
                $zip = new ZipArchive();
                $zip->open($sourcePath, ZipArchive::RDONLY);
                $zip->extractTo($destinationPath);
            },
            self::TYPE_GZIP => function () use ($sourcePath, $destinationPath) {
                $phar = new PharData($sourcePath);
                $phar->extractTo($destinationPath);
            },
        };
        $handler();
    }
}
