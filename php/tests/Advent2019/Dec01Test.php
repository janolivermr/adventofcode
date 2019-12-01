<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec01\PartOne;
use AoC\Advent2019\Dec01\PartTwo;
use PHPUnit\Framework\TestCase;

class Dec01Test extends TestCase
{
    /**
     * @dataProvider partOneExamplesProvider
     */
    public function testPartOneExample($mass, $fuel)
    {
        $this->assertEquals($fuel, PartOne::calculateFuel($mass));
    }

    /**
     * @dataProvider partTwoExamplesProvider
     */
    public function testPartTwoExample($mass, $fuel)
    {
        $this->assertEquals($fuel, PartTwo::calculateFuelRecursive($mass));
    }

    public function partOneExamplesProvider()
    {
        return [
            [12, 2],
            [14, 2],
            [1969, 654],
            [100756, 33583],
        ];
    }

    public function partTwoExamplesProvider()
    {
        return [
            [14, 2],
            [1969, 966],
            [100756, 50346],
        ];
    }
}