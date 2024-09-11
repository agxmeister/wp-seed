<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

use Codeception\Module\Cli;
use Codeception\TestInterface;

class Filesystem extends Cli
{
    const string BASE_PATH = '/tmp';

    public function _before(TestInterface $test): void
    {
        $this->runShellCommand("rm -rf " . self::BASE_PATH . DIRECTORY_SEPARATOR . "*");
    }

    public function createFileStructure($paths): void
    {
        foreach (
            array_map(
                fn($path) => self::BASE_PATH . DIRECTORY_SEPARATOR . $path,
                $paths
            ) as $path
        ) {
            $this->runShellCommand("mkdir -p '$path'");
        }
    }
}
