<?php

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Seed\GuzzleHttp;
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
    Storage::class => DI\factory(fn() => new Storage('/tmp/seed')),
    GuzzleHttpClient::class => DI\factory(function () {
        $handler = !getenv('TEST')
            ? new CurlHandler()
            : new MockHandler([
                new Response(200, [], ''),
                new Response(200, [], ''),
            ]);
        $handlerStack = HandlerStack::create($handler);
        return new GuzzleHttpClient([
            'handler' => $handlerStack,
        ]);
    }),
    Downloader::class => DI\autowire(GuzzleHttp::class),
];
