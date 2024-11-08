<?php

use DI\Container;
use Minicli\App;
use Seed\Command\CreateDatabase;
use Seed\Command\Extract;
use Seed\Command\GetCore;
use Seed\Command\GetDatabaseDump;
use Seed\Command\GetDifferentPaths;
use Seed\Command\GetStructure;
use Seed\Command\InstallClean;
use Seed\Command\InstallPackage;
use Seed\Command\RestoreDatabaseDump;
use Seed\Command\Utils;
use Seed\Command\WpCliGate;

return function (App $app, Container $container) {
    $app->registerCommand('utils', $container->get(Utils::class));
    $app->registerCommand('get-different-paths', $container->get(GetDifferentPaths::class));
    $app->registerCommand('get-structure', $container->get(GetStructure::class));
    $app->registerCommand('get-core', $container->get(GetCore::class));
    $app->registerCommand('extract', $container->get(Extract::class));
    $app->registerCommand('create-database', $container->get(CreateDatabase::class));
    $app->registerCommand('get-database-dump', $container->get(GetDatabaseDump::class));
    $app->registerCommand('restore-database-dump', $container->get(RestoreDatabaseDump::class));
    $app->registerCommand('install-clean', $container->get(InstallClean::class));
    $app->registerCommand('install-package', $container->get(InstallPackage::class));
    $app->registerCommand('wp-cli-gate', $container->get(WpCliGate::class));
};
