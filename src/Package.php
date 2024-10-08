<?php

namespace Seed;

use PharData;
use ZipArchive;

readonly class Package
{
    const string TYPE_ZIP = 'zip';
    const string TYPE_GZIP = 'tar.gz';
    const string VERSION_LATEST = 'latest';

    public function __construct(private File $file, private string $baseUrl)
    {
    }

    public function getCore(string $filename, string $version = null, $type = null): void
    {
        $url = $this->baseUrl . '/' . (is_null($version) ? self::VERSION_LATEST : 'wordpress-' . $version) . '.' . ($type ?? self::TYPE_ZIP);
        $this->file->getByUrl($url, $filename);
    }

    public function extract(string $sourcePath, string $destinationPath, $type = null): void
    {
        $handler = match($type) {
            null, self::TYPE_ZIP => function () use ($sourcePath, $destinationPath) {
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
