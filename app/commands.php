<?php

use DI\Container;
use Minicli\App;
use Seed\Command\CreateDatabase;
use Seed\Command\Extract;
use Seed\Command\GetCore;
use Seed\Command\GetDifferentPaths;
use Seed\Command\GetStructure;
use Seed\Command\Install;
use Seed\Command\Utils;

return function (App $app, Container $container) {
    $app->registerCommand('utils', $container->get(Utils::class));
    $app->registerCommand('get-different-paths', $container->get(GetDifferentPaths::class));
    $app->registerCommand('get-structure', $container->get(GetStructure::class));
    $app->registerCommand('get-core', $container->get(GetCore::class));
    $app->registerCommand('extract', $container->get(Extract::class));
    $app->registerCommand('create-database', $container->get(CreateDatabase::class));
    $app->registerCommand('install', $container->get(Install::class));
};
