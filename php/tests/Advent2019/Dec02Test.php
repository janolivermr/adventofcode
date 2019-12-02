<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec02\PartOne;
use PHPUnit\Framework\TestCase;

class Dec02Test extends TestCase
{
    /**
     * @dataProvider partOneExamplesProvider
     */
    public function testPartOneExample($input, $output)
    {
        $this->assertEquals($output, implode(',', PartOne::processCode(explode(',', $input))));
    }

    public function partOneExamplesProvider()
    {
        return [
            ['1,0,0,0,99', '2,0,0,0,99'],
            ['2,3,0,3,99', '2,3,0,6,99'],
            ['2,4,4,5,99,0', '2,4,4,5,99,9801'],
            ['1,1,1,4,99,5,6,0,99', '30,1,1,4,2,5,6,0,99'],
        ];
    }
}