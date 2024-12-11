<?php

namespace Seed;

use PharData;
use ZipArchive;

readonly class Package
{
    public function __construct()
    {
    }

    public function extract(string $sourcePath, string $destinationPath, $type = null): void
    {
        $handler = match($type) {
            null, PackageType::TYPE_ZIP => function () use ($sourcePath, $destinationPath) {
                $zip = new ZipArchive();
                $zip->open($sourcePath, ZipArchive::RDONLY);
                $zip->extractTo($destinationPath);
            },
            PackageType::TYPE_GZIP, PackageType::TYPE_TAR => function () use ($sourcePath, $destinationPath) {
                $phar = new PharData($sourcePath);
                $phar->extractTo($destinationPath);
            },
        };
        $handler();
    }
}
