<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

use Codeception\Module;
use DI\Container;

class Di extends Module
{
    public function getContainer(): Container
    {
        $dependencies = require __DIR__ . '/../../../app/dependencies.php';
        return new Container($dependencies);
    }
}
