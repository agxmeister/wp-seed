<?php

use DI\Container;
use Minicli\App;
use Seed\Command\CreateDatabase;
use Seed\Command\Extract;
use Seed\Command\GetCore;
use Seed\Command\GetDifferentPaths;
use Seed\Command\GetStructure;

return function (App $app, Container $container) {
    $app->registerCommand('get-different-paths', $container->get(GetDifferentPaths::class));
    $app->registerCommand('get-structure', $container->get(GetStructure::class));
    $app->registerCommand('get-core', $container->get(GetCore::class));
    $app->registerCommand('extract', $container->get(Extract::class));
    $app->registerCommand('create-database', $container->get(CreateDatabase::class));
};
