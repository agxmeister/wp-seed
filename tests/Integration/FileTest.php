<?php

namespace Integration;

use Codeception\Attribute\DataProvider;
use Codeception\Test\Unit;
use DI;
use Seed\Downloader;
use Seed\File;
use Seed\GuzzleHttp;
use Tests\Support\IntegrationTester;

class FileTest extends Unit
{
    protected IntegrationTester $tester;

    #[DataProvider('dataGetByUrl')]
    public function testGetByUrl($file, $expected): void
    {
        $container = $this->tester->getContainer();
        $container->set(Downloader::class, DI\factory(
            fn() => $this->make(GuzzleHttp::class, ['download' => function () use ($expected) {
                file_put_contents($expected, 'test');
            }])
        ));
        $path = $container->get(File::class)->getByUrl('https://wordpress.org/' . $file, $file);
        $this->tester->runShellCommand("ls -l $path");
    }

    static public function dataGetByUrl(): array
    {
        return [
            ['wordpress-6.6.2.zip', '/tmp/seed/wordpress-6.6.2.zip'],
        ];
    }
}
