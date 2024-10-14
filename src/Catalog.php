<?php

namespace Seed;

readonly class Catalog
{
    const string PACKAGE_VERSION_LATEST = 'latest';

    public function __construct(private string $baseCoreUrl, private string $baseAssetUrl)
    {
    }

    public function getCorePackageUrl(string $version = null, PackageType $type = null): string
    {
        return $this->baseCoreUrl . '/' .
            (is_null($version) ? self::PACKAGE_VERSION_LATEST : 'wordpress-' . $version) . '.' .
            (is_null($type) ? PackageType::TYPE_ZIP->value : $type->value);
    }

    public function getPluginPackageUrl(string $name, string $version = null): string
    {
        return $this->getAssetPackageUrl(AssetType::TYPE_PLUGIN, $name, $version);
    }

    public function getThemePackageUrl(string $name, string $version = null): string
    {
        return $this->getAssetPackageUrl(AssetType::TYPE_THEME, $name, $version);
    }

    protected function getAssetPackageUrl(AssetType $type, string $name, string $version = null): string
    {
        return $this->baseAssetUrl . '/' . $type->value . '/' . $name . ($version ? '.' . $version : '') . '.zip';
    }
}
