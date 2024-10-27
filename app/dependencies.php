<?php

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Seed\Catalog;
use Seed\Destination;
use Seed\Downloader\Downloader;
use Seed\Downloader\GuzzleHttp;
use Seed\Mysql;
use Seed\Storage;
use Seed\Tools;
use Seed\Setup;

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
    Tools::class => DI\autowire()->constructor(basePath: './dst/tools'),
    Storage::class => DI\autowire()->constructor(basePath: './dst/packages'),
    Destination::class => DI\autowire()->constructor(basePath: './dst/web'),
    Downloader::class => DI\autowire(GuzzleHttp::class),
    Mysql::class => DI\autowire()->constructor(
        host: 'mysql',
        port: null,
        username: 'root',
        password: null,
    ),
    Setup::class => DI\autowire()->constructor(
        wpCliUrl: 'https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar',
    )
];
