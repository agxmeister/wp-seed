<?php

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Seed\Catalog;
use Seed\Downloader\Downloader;
use Seed\Downloader\GuzzleHttp;
use Seed\Storage;

return [
    Logger::class => DI\factory(function () {
        $logger = new Logger('log');
        $fileHandler = new StreamHandler('./dst/main.log', Level::Debug);
        $fileHandler->setFormatter(new LineFormatter());
        return $logger->pushHandler($fileHandler);
    }),
    Catalog::class => DI\autowire()
        ->constructor(
            baseCoreUrl: !getenv('TEST') ? 'https://wordpress.org' : 'http://localhost:8080',
            baseAssetUrl: !getenv('TEST') ? 'https://downloads.wordpress.org' : 'http://localhost:8080',
        ),
    Storage::class => DI\autowire()
        ->constructor(basePath: './dst/packages'),
    Downloader::class => DI\autowire(GuzzleHttp::class),
];
