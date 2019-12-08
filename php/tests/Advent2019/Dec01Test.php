<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec01;
use Tests\TestCaseWithInput;

class Dec01Test extends TestCaseWithInput
{
    /**
     * @dataProvider partOneExamplesProvider
     */
    public function testPartOneExample($mass, $fuel)
    {
        $this->assertEquals($fuel, Dec01::calculateFuel($mass));
    }

    /**
     * @dataProvider partTwoExamplesProvider
     */
    public function testPartTwoExample($mass, $fuel)
    {
        $this->assertEquals($fuel, Dec01::calculateFuelRecursive($mass));
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

    public function runPartOne()
    {
        $fuelRequired = 0;
        foreach ($this->getInput() as $record) {
            $fuelRequired += Dec01::calculateFuel((int)$record[0]);
        }
        return $fuelRequired;
    }

    public function runPartTwo()
    {
        $fuelRequired = 0;
        foreach ($this->getInput() as $record) {
            $fuelRequired += Dec01::calculateFuelRecursive((int)$record[0]);
        }
        return $fuelRequired;
    }
}