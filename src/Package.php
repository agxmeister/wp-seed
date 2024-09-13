<?php

namespace Seed;

class Package
{
    const string BASE_URL_CORE = 'https://wordpress.org';

    public function getCore(string $destinationPath): void
    {
        $url = self::BASE_URL_CORE . '/latest.zip';
        $curl = curl_init($url);
        $file = fopen($destinationPath, 'wb');
        curl_setopt($curl, CURLOPT_FILE, $file);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_exec($curl);
        curl_close($curl);
        fclose($file);
    }
}
