<?php

use DI\ContainerBuilder;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Seed\FakePackageFetcher;
use Seed\File;
use Seed\PackageFetcher;
use Seed\Storage;

return function (ContainerBuilder $containerBuilder)
{
    $containerBuilder->addDefinitions([
        Logger::class => DI\factory(function () {
            $logger = new Logger('log');
            $fileHandler = new StreamHandler('./dst/main.log', Level::Debug);
            $fileHandler->setFormatter(new LineFormatter());
            return $logger->pushHandler($fileHandler);
        }),
        Storage::class => DI\factory(fn() => new Storage('/tmp/seed')),
        PackageFetcher::class => getenv('TEST') !== 'true' ? DI\autowire(File::class) : DI\autowire(FakePackageFetcher::class),
    ]);
};
