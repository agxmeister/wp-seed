<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use Seed\Utils;

class UtilsTest extends Unit
{
    /**
     * @dataProvider dataGetDifferentPaths
     */
    public function testGetDifferentPaths($pathA, $pathB, $expected): void
    {
        $this->assertEquals($expected, Utils::getDifferentPaths($pathA, $pathB));
    }

    static public function dataGetDifferentPaths(): array
    {
        return [
            [
                [], [], [],
            ], [
                [], ['f1'], [],
            ], [
                [], ['d1' => 'd1/f1'], [],
            ], [
                ['f1'], ['f1'], [],
            ], [
                ['d1' => ['d1/f1']], ['d1' => ['d1/f1']], [],
            ], [
                ['f1'], ['f2'], ['f1'],
            ], [
                ['d1' => ['d1/f1']], ['d2' => ['d2/f2']], ['d1/f1'],
            ], [
                ['f1'], ['f1', 'f2'], [],
            ], [
                ['d1' => ['d1/f1']], ['d1' => ['d1/f1'], 'd2' => ['d2/f2']], [],
            ], [
                ['f1', 'f2'], ['f1'], ['f2'],
            ], [
                ['d1' => ['d1/f1'], 'd2' => ['d2/f2']], ['d1' => ['d1/f1']], ['d2/f2'],
            ], [
                ['d1' => ['d1/f1'], 'f2'], [], ['d1/f1', 'f2'],
            ], [
                ['f1'], [], ['f1'],
            ], [
                ['d1' => ['d1/f1']], [], ['d1/f1'],
            ], [
                ['d1' => ['d2' => ['d1/d2/f1']]], [], ['d1/d2/f1'],
            ], [
                ['d1' => ['d2' => ['d1/d2/f1']], 'f2'], ['f2'], ['d1/d2/f1'],
            ], [
                ['d1' => ['d2' => ['d1/d2/f1'], 'd1/f2']], ['d1' => ['d1/f2']], ['d1/d2/f1'],
            ], [
                ['d1' => ['d2' => ['d1/d2/f1'], 'd1/f2']], ['d1' => ['d2' => ['d1/d2/f1'], 'd1/f2']], [],
            ],
        ];
    }
}
