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
        $I->runShellCommand("./bin/seed get-structure /tmp");
        $I->seeInShellOutput("");
    }
}
