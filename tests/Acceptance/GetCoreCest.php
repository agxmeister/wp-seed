<?php

namespace Tests\Acceptance;

use Codeception\Attribute\Examples;
use Codeception\Example;
use Tests\Support\AcceptanceTester;

class GetCoreCest
{
    #[Examples(
        ['./bin/seed get-core --filename=latest.zip', 'latest.zip'],
        ['./bin/seed get-core --version=5.9.10 --filename=wordpress-5.9.10.zip', 'wordpress-5.9.10.zip'],
        ['./bin/seed get-core --type=tar.gz --filename=latest.tar.gz', 'latest.tar.gz'],
        ['./bin/seed get-core --version=5.9.10 --type=tar.gz --filename=wordpress-5.9.10.tar.gz', 'wordpress-5.9.10.tar.gz'],
    )]
    public function testGetCore(AcceptanceTester $I, Example $example): void
    {
        [$command, $path] = $example;
        $I->runShellCommand($command);
        $I->seeResultCodeIs(0);
        $basePath = $I->getBasePackagePath();
        $I->runShellCommand("ls -l $basePath/$path");
    }
}
