<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class GetCoreCest
{
    public function getLatestTest(AcceptanceTester $I): void
    {
        $I->runShellCommand("./bin/seed get-core --filename=latest.zip");
        $I->seeResultCodeIs(0);
        $basePath = $I->getBasePackagePath();
        $I->runShellCommand("ls -l $basePath/latest.zip");
    }

    public function getVersionTest(AcceptanceTester $I): void
    {
        $I->runShellCommand("./bin/seed get-core --version=5.9.10 --filename=wordpress-5.9.10.zip");
        $I->seeResultCodeIs(0);
        $basePath = $I->getBasePackagePath();
        $I->runShellCommand("ls -l $basePath/wordpress-5.9.10.zip");
    }
}
