<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

use Codeception\Module\Cli;
use Codeception\TestInterface;

class Filesystem extends Cli
{
    const string BASE_PATH = '/tmp/seed';

    public function _before(TestInterface $test): void
    {
        $this->runShellCommand("rm -rf " . self::BASE_PATH);
        $this->runShellCommand("mkdir -p " . self::BASE_PATH);
    }

    public function getBasePath(): string
    {
        return self::BASE_PATH;
    }

    public function createFileStructure($paths): void
    {
        foreach (
            array_map(
                fn($path) => self::BASE_PATH . DIRECTORY_SEPARATOR . $path,
                $paths
            ) as $path
        ) {
            if (str_ends_with($path, DIRECTORY_SEPARATOR)) {
                $this->runShellCommand("mkdir -p '" . rtrim($path, DIRECTORY_SEPARATOR) . "'");
                continue;
            }
            $this->runShellCommand("mkdir -p '" . dirname($path) . "'");
            $this->runShellCommand("touch '$path'");
        }
    }
}
