<?php

namespace Tests\Acceptance;

use Codeception\Attribute\Examples;
use Codeception\Example;
use Tests\Support\AcceptanceTester;

class GetStructureCest
{
    #[Examples(
        [
            [
                'test',
            ],
            [
                'test' => [],
            ],
        ], [
            [
                'test1',
                'test2',
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
        $I->createFileStructure($paths);
        $I->runShellCommand("./bin/seed get-structure /tmp");
        $structure = json_decode($I->grabShellOutput(), true);
        $I->assertEquals($expected, $structure);
    }
}
