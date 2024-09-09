<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class GetStructureCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function tryToTest(AcceptanceTester $I): void
    {
        $I->runShellCommand("mkdir -p /tmp/test");
        $I->runShellCommand("./bin/seed get-structure /tmp");
        $structure = json_decode($I->grabShellOutput(), true);
        $I->assertEquals(['test' => []], $structure);
    }
}
