<?php

use Minicli\App;
use Seed\Command\GetDifferentPaths;
use Seed\Command\GetStructure;

return function (App $app) {
    $app->registerCommand('get-different-paths', new GetDifferentPaths());
    $app->registerCommand('get-structure', new GetStructure());
};
