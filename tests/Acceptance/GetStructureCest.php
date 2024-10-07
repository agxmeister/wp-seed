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
                'd/',
            ], [
                'd' => [],
            ],
        ], [
            [
                'd/f',
            ], [
                'd' => ['f' => 'f'],
            ],
        ], [
            [
                'd1/',
                'd2/',
            ], [
                'd1' => [],
                'd2' => [],
            ],
        ],
    )]
    public function tryToTest(AcceptanceTester $I, Example $example): void
    {
        [$paths, $expected] = $example;
        $I->createFileStructure($paths);
        $basePath = $I->getBaseTmpPath();
        $I->runShellCommand("./bin/seed get-structure $basePath");
        $structure = json_decode($I->grabShellOutput(), true);
        $I->assertEquals($expected, $structure);
    }
}
