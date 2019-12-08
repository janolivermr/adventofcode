<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec02;
use Tests\TestCaseWithInput;

class Dec02Test extends TestCaseWithInput
{
    /**
     * @dataProvider partOneExamplesProvider
     */
    public function testPartOneExample($input, $output)
    {
        $dec02 = new Dec02(explode(',', $input));
        $dec02->processAll();
        $this->assertEquals($output, implode(',', $dec02->getState()));
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

    public function runPartOne()
    {
        $dec02 = new Dec02(iterator_to_array($this->getInput())[0]);
        $dec02->processAll();
        return $dec02->getState()[0];
    }

    public function runPartTwo()
    {
        $data = iterator_to_array($this->getInput())[0];
        for ($noun = 0; $noun <= 99; $noun++) {
            for ($verb = 0; $verb <= 99; $verb++) {
                $data[1] = $noun;
                $data[2] = $verb;
                $dec02 = new Dec02($data);
                $dec02->processAll();
                if ($dec02->getState()[0] === 19690720) {
                    return 100 * $noun + $verb;
                }
            }
        }
    }
}