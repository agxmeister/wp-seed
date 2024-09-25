<?php

namespace Seed;

readonly class File implements PackageFetcher
{
    public function __construct(private Storage $storage)
    {
    }

    public function getByUrl(string $url, string $fileName): string
    {
        $destinationPath = $this->storage->getPath($fileName);
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
