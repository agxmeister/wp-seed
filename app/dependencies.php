<?php

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Seed\GuzzleHttp;
use Seed\Package;
use Seed\Storage;
use Seed\Downloader;
use Seed\Http;
use Seed\FakeHttp;

return [
    Logger::class => DI\factory(function () {
        $logger = new Logger('log');
        $fileHandler = new StreamHandler('./dst/main.log', Level::Debug);
        $fileHandler->setFormatter(new LineFormatter());
        return $logger->pushHandler($fileHandler);
    }),
    Package::class => DI\autowire()
        ->constructor(baseUrl: !getenv('TEST') ? 'https://wordpress.org' : 'http://localhost:8080'),
    Storage::class => DI\autowire()
        ->constructor(basePath: './dst/packages'),
    Downloader::class => DI\autowire(GuzzleHttp::class),
];
