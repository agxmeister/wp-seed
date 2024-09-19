<?php

namespace Seed;

readonly class File
{
    public function __construct(private string $basePath)
    {
    }

    public function getByUrl(string $url, string $fileName): string
    {
        $destinationPath = $this->basePath . "/" . $fileName;
        $curl = curl_init($url);
        $file = fopen($destinationPath, 'wb');
        curl_setopt($curl, CURLOPT_FILE, $file);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_exec($curl);
        curl_close($curl);
        fclose($file);
        return $destinationPath;
    }
}
