<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec04;
use Tests\TestCaseWithInput;

class Dec04Test extends TestCaseWithInput
{
    /**
     * @dataProvider partOneExamplesProvider
     */
    public function testPartOneExample($password, $valid)
    {
        $this->assertEquals($valid, Dec04::isValidPassword($password));
    }

    /**
     * @dataProvider partTwoExamplesProvider
     */
    public function testPartTwoExample($password, $valid)
    {
        $this->assertEquals($valid, Dec04::isValidPassword($password, true));
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

    public function runPartOne()
    {
        $dec04 = new Dec04(iterator_to_array($this->getInput())[0][0]);
        return $dec04->getValidPasswords();
    }

    public function runPartTwo()
    {
        $dec04 = new Dec04(iterator_to_array($this->getInput())[0][0]);
        return $dec04->getValidPasswords(true);
    }
}