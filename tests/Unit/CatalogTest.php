<?php

namespace Tests\Unit;

use Codeception\Attribute\DataProvider;
use Codeception\Test\Unit;
use Seed\Catalog;
use Seed\PackageType;

class CatalogTest extends Unit
{
    #[DataProvider('dataGetCorePackageUrl')]
    public function testGetCorePackageUrl($version, $type, $expected): void
    {
        $catalog = new Catalog('https://wordpress.org', 'https://downloads.wordpress.org');
        $this->assertEquals($expected, $catalog->getCorePackageUrl($version, $type));
    }

    #[DataProvider('dataGetPluginPackageUrl')]
    public function testGetPluginPackageUrl($name, $version, $expected): void
    {
        $catalog = new Catalog('https://wordpress.org', 'https://downloads.wordpress.org');
        $this->assertEquals($expected, $catalog->getPluginPackageUrl($name, $version));
    }

    #[DataProvider('dataGetThemePackageUrl')]
    public function testGetThemePackageUrl($name, $version, $expected): void
    {
        $catalog = new Catalog('https://wordpress.org', 'https://downloads.wordpress.org');
        $this->assertEquals($expected, $catalog->getThemePackageUrl($name, $version));
    }

    static public function dataGetCorePackageUrl(): array
    {
        return [
            [null, null, 'https://wordpress.org/latest.zip'],
            [null, PackageType::TYPE_GZIP, 'https://wordpress.org/latest.tar.gz'],
            ['5.4.3', null, 'https://wordpress.org/wordpress-5.4.3.zip'],
            ['5.4.3', PackageType::TYPE_ZIP, 'https://wordpress.org/wordpress-5.4.3.zip'],
            ['5.4.3', PackageType::TYPE_GZIP, 'https://wordpress.org/wordpress-5.4.3.tar.gz'],
        ];
    }

    static public function dataGetPluginPackageUrl(): array
    {
        return [
            ['ultimate-addons-for-gutenberg', null, 'https://downloads.wordpress.org/plugin/ultimate-addons-for-gutenberg.zip'],
            ['ultimate-addons-for-gutenberg', '2.3.4', 'https://downloads.wordpress.org/plugin/ultimate-addons-for-gutenberg.2.3.4.zip'],
        ];
    }

    static public function dataGetThemePackageUrl(): array
    {
        return [
            ['astra', null, 'https://downloads.wordpress.org/theme/astra.zip'],
            ['astra', '4.8.3', 'https://downloads.wordpress.org/theme/astra.4.8.3.zip'],
        ];
    }
}
