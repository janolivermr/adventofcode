<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec04\PartOne;
use AoC\Advent2019\Dec04\PartTwo;
use PHPUnit\Framework\TestCase;

class Dec04Test extends TestCase
{
    /**
     * @dataProvider partOneExamplesProvider
     */
    public function testPartOneExample($password, $valid)
    {
        $this->assertEquals($valid, PartOne::isValidPassword($password));
    }

    /**
     * @dataProvider partTwoExamplesProvider
     */
    public function testPartTwoExample($password, $valid)
    {
        $this->assertEquals($valid, PartTwo::isValidPassword($password));
    }

    public function partOneExamplesProvider()
    {
        return [
            ['122345', true],
            ['111123', true],
            ['111111', true],
            ['223450', false],
            ['123789', false],
        ];
    }

    public function partTwoExamplesProvider()
    {
        return [
            ['112233', true],
            ['123444', false],
            ['111122', true],
            ['124444', false],
            ['112444', true],
        ];
    }
}