<?php

use DI\Container;
use Minicli\App;
use Seed\Command\GetDifferentPaths;
use Seed\Command\GetStructure;

return function (App $app, Container $container) {
    $app->registerCommand('get-different-paths', $container->get(GetDifferentPaths::class));
    $app->registerCommand('get-structure', $container->get(GetStructure::class));
};
