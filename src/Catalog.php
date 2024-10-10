<?php

namespace Seed;

readonly class Catalog
{
    const string PACKAGE_VERSION_LATEST = 'latest';

    public function __construct(private string $baseUrl)
    {
    }

    public function getCorePackageUrl($version = null, PackageType $type = null): string
    {
        return $this->baseUrl . '/' .
            (is_null($version) ? self::PACKAGE_VERSION_LATEST : 'wordpress-' . $version) . '.' .
            (is_null($type) ? PackageType::TYPE_ZIP->value : $type->value);
    }
}
