<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec12;
use Tests\TestCaseWithInput;

class Dec12Test extends TestCaseWithInput
{
    /**
     * @dataProvider examplesProvider
     */
    public function testPartOneExamples($input, $steps, $expectedEnergy)
    {
        $dec12 = new Dec12($input);
        for ($i = 0; $i < $steps; $i++) {
            $dec12->calculateStep();
        }
        $this->assertEquals($expectedEnergy, $dec12->calculateEnergy());
    }

    /**
     * @dataProvider examplesProvider
     */
    public function testPartTwoExamples($input, $steps, $expectedEnergy, $expectedCycles)
    {
        $dec12 = new Dec12($input);
        $this->assertEquals($expectedCycles, $dec12->stepsToInitialState());
    }

    public function runPartOne()
    {
        $input = array_map(function ($row) {
            return implode(',', $row);
        }, iterator_to_array($this->getInput()));
        $dec12 = new Dec12($input);
        for ($i = 0; $i < 1000; $i++) {
            $dec12->calculateStep();
        }
        return $dec12->calculateEnergy();
    }

    public function runPartTwo()
    {
        $input = array_map(function ($row) {
            return implode(',', $row);
        }, iterator_to_array($this->getInput()));
        $dec12 = new Dec12($input);
        for ($i = 0; $i < 1000; $i++) {
            $dec12->calculateStep();
        }
        return $dec12->stepsToInitialState();
    }

    public function examplesProvider()
    {
        return [
            [[
                '<x=-1, y=0, z=2>',
                '<x=2, y=-10, z=-7>',
                '<x=4, y=-8, z=8>',
                '<x=3, y=5, z=-1>',
            ], 10, 179, 2772],
            [[
                '<x=-8, y=-10, z=0>',
                '<x=5, y=5, z=10>',
                '<x=2, y=-7, z=3>',
                '<x=9, y=-8, z=-3>'
            ], 100, 1940, 4686774924]
        ];
    }
}