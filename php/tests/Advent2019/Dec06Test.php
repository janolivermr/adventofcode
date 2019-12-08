<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec06;
use Tests\TestCaseWithInput;

class Dec06Test extends TestCaseWithInput
{
    /**
     * @dataProvider partOneExamplesProvider
     */
    public function testPartOne($map, $expectedOutput)
    {
        $dec06 = new Dec06($map);
        $this->assertEquals($expectedOutput, $dec06->getOrbitTotal());
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
        $dec06 = new Dec06($map);
        $this->assertEquals($expectedOutput, $dec06->getOrbitTransfers('YOU', 'SAN'));
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

    public function runPartOne()
    {
        $map = array_map(function ($record) {
            return $record[0];
        }, iterator_to_array($this->getInput()));
        $dec06 = new Dec06($map);
        return $dec06->getOrbitTotal();
    }

    public function runPartTwo()
    {
        $map = array_map(function ($record) {
            return $record[0];
        }, iterator_to_array($this->getInput()));
        $dec06 = new Dec06($map);
        return $dec06->getOrbitTransfers('YOU', 'SAN');
    }
}