<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec06\PartOne;
use AoC\Advent2019\Dec06\PartTwo;
use PHPUnit\Framework\TestCase;

class Dec06Test extends TestCase
{
    /**
     * @dataProvider partOneExamplesProvider
     */
    public function testPartOne($map, $expectedOutput)
    {
        $partOne = new PartOne(array_map(function ($el) { return [$el]; }, $map));
        $this->assertEquals($expectedOutput, $partOne->getOrbitTotal());
    }

    public function partOneExamplesProvider()
    {
        return [
            'example' => [[
                'COM)B',
                'B)C',
                'C)D',
                'D)E',
                'E)F',
                'B)G',
                'G)H',
                'D)I',
                'E)J',
                'J)K',
                'K)L',
            ], 42],
        ];
    }

    /**
     * @dataProvider partTwoExamplesProvider
     */
    public function testPartTwo($map, $expectedOutput)
    {
        $partTwo = new PartTwo(array_map(function ($el) { return [$el]; }, $map));
        $this->assertEquals($expectedOutput, $partTwo->getOrbitTransfers('YOU', 'SAN'));
    }

    public function partTwoExamplesProvider()
    {
        return [
            'example' => [[
                'COM)B',
                'B)C',
                'C)D',
                'D)E',
                'E)F',
                'B)G',
                'G)H',
                'D)I',
                'E)J',
                'J)K',
                'K)L',
                'K)YOU',
                'I)SAN',
            ], 4],
        ];
    }

    public function testWithInputPartOne()
    {
        $partOne = new PartOne();
        $this->assertTrue(true);
        echo sprintf('Result: %s', $partOne->getOrbitTotal());
    }

    public function testWithInputPartTwo()
    {
        $partTwo = new PartTwo();
        $this->assertTrue(true);
        echo sprintf('Result: %s', $partTwo->getOrbitTransfers('YOU', 'SAN'));
    }
}