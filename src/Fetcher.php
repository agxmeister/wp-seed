<?php

namespace Seed;

readonly class Fetcher
{
    public function __construct(private Catalog $catalog, private Storage $storage, private File $file)
    {
    }

    public function getCore(?string $version = null, ?string $filename = null, ?PackageType $type = null): string
    {
        $url = $this->catalog->getCorePackageUrl($version, $type);
        $destinationPath = $this->storage->getPackagePath($filename ?? basename(parse_url($url, PHP_URL_PATH)));
        $this->file->getByUrl($url, $destinationPath);
        return $destinationPath;
    }
}
