<?php

namespace Tests\Acceptance;

use Codeception\Attribute\Examples;
use Codeception\Example;
use Tests\Support\AcceptanceTester;

class GetStructureCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->runShellCommand("rm -rf /tmp/*");
    }

    #[Examples(
        [
            [
                '/tmp/test',
            ],
            [
                'test' => [],
            ],
        ], [
            [
                '/tmp/test1',
                '/tmp/test2',
            ],
            [
                'test1' => [],
                'test2' => [],
            ],
        ],
    )]
    public function tryToTest(AcceptanceTester $I, Example $example): void
    {
        [$paths, $expected] = $example;
        foreach ($paths as $path) {
            $I->runShellCommand("mkdir -p '$path'");
        }
        $I->runShellCommand("./bin/seed get-structure /tmp");
        $structure = json_decode($I->grabShellOutput(), true);
        $I->assertEquals($expected, $structure);
    }
}
