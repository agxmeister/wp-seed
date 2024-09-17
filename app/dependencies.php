<?php

use DI\ContainerBuilder;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder)
{
    $containerBuilder->addDefinitions([
        Logger::class => DI\factory(function () {
            $logger = new Logger('log');
            $fileHandler = new StreamHandler('./dst/main.log', Level::Debug);
            $fileHandler->setFormatter(new LineFormatter());
            return $logger->pushHandler($fileHandler);
        }),
    ]);
};
