<?php

namespace Seed;

use PharData;
use ZipArchive;

readonly class Package
{
    const string TYPE_ZIP = 'zip';
    const string TYPE_GZIP = 'tar.gz';

    public function __construct(private Catalog $catalog, private File $file)
    {
    }

    public function getCore(string $version = null, string $filename = null, PackageType $type = null): void
    {
        $url = $this->catalog->getCorePackageUrl($version, $type);
        $this->file->getByUrl(
            $url,
            $filename ?? basename(parse_url($url, PHP_URL_PATH)),
        );
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
