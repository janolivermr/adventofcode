<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec03\PartOne;
use AoC\Advent2019\Dec03\PartTwo;
use PHPUnit\Framework\TestCase;

class Dec03Test extends TestCase
{
    /**
     * @dataProvider partOneExamplesProvider
     */
    public function testPartOneExample($wireOne, $wireTwo, $outputDistance, $outputLength)
    {
        $partOne = new PartOne();
        $this->assertEquals($outputDistance, $partOne->getClosestCrossingPoint(explode(',', $wireOne), explode(',', $wireTwo)));
    }

    /**
     * @dataProvider partOneExamplesProvider
     */
    public function testPartTwoExample($wireOne, $wireTwo, $outputDistance, $outputLength)
    {
        $partTwo = new PartTwo();
        $this->assertEquals($outputLength, $partTwo->getShortestWireLength(explode(',', $wireOne), explode(',', $wireTwo)));
    }

    public function partOneExamplesProvider()
    {
        return [
            ['R8,U5,L5,D3', 'U7,R6,D4,L4', 6, 30],
            ['R75,D30,R83,U83,L12,D49,R71,U7,L72','U62,R66,U55,R34,D71,R55,D58,R83', 159, 610],
            ['R98,U47,R26,D63,R33,U87,L62,D20,R33,U53,R51', 'U98,R91,D20,R16,D67,R40,U7,R15,U6,R7', 135, 410]
        ];
    }
}