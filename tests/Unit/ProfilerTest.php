<?php

namespace Tests\Unit;

use Codeception\Attribute\DataProvider;
use Codeception\Test\Unit;
use Seed\Profiler;

class ProfilerTest extends Unit
{
    #[DataProvider('dataCheckpoints')]
    public function testCheck($checks): void
    {
        $profiler = new Profiler();
        foreach ($checks as $check) {
            $profiler->check($check);
        }
        $report = json_decode($profiler->report(), true);
        $this->assertEquals($checks, array_keys($report['checks']));
        $this->assertEquals(
            true,
            array_reduce(
                $report['checks'],
                fn($acc, $check) => min($acc, $check),
                0
            ) === 0,
            "There are negative length checkpoints.",
        );
    }

    #[DataProvider('dataCheckpoints')]
    public function testCheckFinalize($checks): void
    {
        $profiler = new Profiler();
        foreach ($checks as $check) {
            $profiler->check($check);
            $profiler->finalize();
        }
        $report = json_decode($profiler->report(), true);
        $this->assertEquals($checks, array_keys($report['checks']));
        $this->assertEquals(
            true,
            array_reduce(
                $report['checks'],
                fn($acc, $check) => min($acc, $check),
                0
            ) === 0,
            "There are negative length checkpoints.",
        );
    }

    public static function dataCheckpoints(): array
    {
        return [
            [[]],
            [['test']],
            [['test1', 'test2']],
        ];
    }
}
