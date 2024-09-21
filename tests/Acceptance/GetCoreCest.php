<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class GetCoreCest
{
    public function tryToTest(AcceptanceTester $I): void
    {
        $I->runShellCommand("./bin/seed get-core --filename=latest.zip");
        $I->seeResultCodeIs(0);
    }
}
