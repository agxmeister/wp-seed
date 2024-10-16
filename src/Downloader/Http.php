<?php

namespace Seed\Downloader;

readonly class Http implements Downloader
{
    public function download(string $url, string $path): void
    {
        $curl = curl_init($url);
        $file = fopen($path, 'wb');
        curl_setopt($curl, CURLOPT_FILE, $file);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_exec($curl);
        curl_close($curl);
        fclose($file);
    }
}
