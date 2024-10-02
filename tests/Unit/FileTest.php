<?php

namespace Tests\Unit;

use Codeception\Attribute\DataProvider;
use Codeception\Test\Unit;
use DI;
use DI\Container;
use Seed\Downloader;
use Seed\File;
use Seed\GuzzleHttp;

class FileTest extends Unit
{
    #[DataProvider('dataGetByUrl')]
    public function testGetByUrl($file, $expected): void
    {
        $dependencies = require __DIR__ . '/../../app/dependencies.php';
        $container = new Container($dependencies);
        $container->set(Downloader::class, DI\factory(fn() => $this->makeEmpty(GuzzleHttp::class)));
        $path = $container->get(File::class)->getByUrl('https://wordpress.org/' . $file, $file);
        $this->assertEquals($expected, $path);
    }

    static public function dataGetByUrl(): array
    {
        return [
            ['wordpress-6.6.2.zip', '/tmp/seed/wordpress-6.6.2.zip'],
        ];
    }
}
