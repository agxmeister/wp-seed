<?php

namespace Seed;

use PharData;
use ZipArchive;

readonly class Package
{
    const string TYPE_ZIP = 'zip';
    const string TYPE_GZIP = 'tar.gz';
    const string TYPE_TAR = 'tar';

    public function __construct()
    {
    }

    public function extract(string $sourcePath, string $destinationPath, $type = null): void
    {
        $handler = match($type) {
            null, self::TYPE_ZIP => function () use ($sourcePath, $destinationPath) {
                $zip = new ZipArchive();
                $zip->open($sourcePath, ZipArchive::RDONLY);
                $zip->extractTo($destinationPath);
            },
            self::TYPE_GZIP, self::TYPE_TAR => function () use ($sourcePath, $destinationPath) {
                $phar = new PharData($sourcePath);
                $phar->extractTo($destinationPath);
            },
        };
        $handler();
    }
}
