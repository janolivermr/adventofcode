<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec09;
use Tests\TestCaseWithInput;

class Dec09Test extends TestCaseWithInput
{
    /**
     * @dataProvider partOneExamplesProvider
     */
    public function testPartOneExamples($startState, $expectedOutputs)
    {
        $dec09 = new Dec09(explode(',', $startState));
        $dec09->processAll();
        $this->assertEquals($expectedOutputs, $dec09->getOutputs());
    }

    public function runPartOne()
    {
        $inputState = iterator_to_array($this->getInput())[0];
        $dec09 = new Dec09($inputState, [1]);
        $dec09->processAll();
        $outputs = $dec09->getOutputs();
        $this->assertCount(1, $outputs);
        return $outputs[0];
    }

    public function runPartTwo()
    {
        $inputState = iterator_to_array($this->getInput())[0];
        $dec09 = new Dec09($inputState, [2]);
        $dec09->processAll();
        $outputs = $dec09->getOutputs();
        $this->assertCount(1, $outputs);
        return $outputs[0];
    }

    public function partOneExamplesProvider()
    {
        return [
            ['109,1,204,-1,1001,100,1,100,1008,100,16,101,1006,101,0,99', explode(',', '109,1,204,-1,1001,100,1,100,1008,100,16,101,1006,101,0,99')],
            ['1102,34915192,34915192,7,4,7,99,0', [1219070632396864]],
            ['104,1125899906842624,99', [1125899906842624]],
        ];
    }
}