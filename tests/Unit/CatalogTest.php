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
        $catalog = new Catalog('https://wordpress.org');
        $this->assertEquals($expected, $catalog->getCorePackageUrl($version, $type));
    }

    #[DataProvider('dataGetPluginPackageUrl')]
    public function testGetPluginPackageUrl($name, $version, $expected): void
    {
        $catalog = new Catalog('https://wordpress.org');
        $this->assertEquals($expected, $catalog->getPluginPackageUrl($name, $version));
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
            ['ultimate-addons-for-gutenberg', null, 'https://wordpress.org/plugin/ultimate-addons-for-gutenberg.zip'],
            ['ultimate-addons-for-gutenberg', '2.3.4', 'https://wordpress.org/plugin/ultimate-addons-for-gutenberg.2.3.4.zip'],
        ];
    }
}
