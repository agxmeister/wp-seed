<?php

namespace Tests\Acceptance;

use Codeception\Attribute\Examples;
use Codeception\Example;
use Tests\Support\AcceptanceTester;

class GetDifferentPathsCest
{
    #[Examples(
        [
            [
                'a/d/f',
            ], [
                'b/d/',
            ], [
                'd/f',
            ],
        ], [
            [
                'a/d/',
            ], [
                'b/d/f',
            ], [
            ],
        ],
    )]
    public function tryToTest(AcceptanceTester $I, Example $example): void
    {
        [$pathsA, $pathsB, $expected] = $example;
        $I->createFileStructure($pathsA);
        $I->createFileStructure($pathsB);
        $basePath = $I->getBasePath();
        $I->runShellCommand("./bin/seed get-different-paths $basePath/a $basePath/b");
        $structure = json_decode($I->grabShellOutput(), true);
        $I->assertEquals($expected, $structure);
    }
}
