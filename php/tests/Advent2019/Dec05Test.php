<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec05\PartOne;
use AoC\Advent2019\Dec05\PartTwo;
use PHPUnit\Framework\TestCase;

class Dec05Test extends TestCase
{
    /**
     * @dataProvider expectedStateProvider
     */
    public function testExpectedState($startState, $expectedState)
    {
        $partOne = new PartOne(explode(',', $startState));
        $partOne->processAll();
        $this->assertEquals($expectedState, implode(',', $partOne->getState()));
        $partTwo = new PartTwo(explode(',', $startState));
        $partTwo->processAll();
        $this->assertEquals($expectedState, implode(',', $partTwo->getState()));
    }

    public function expectedStateProvider()
    {
        return [
            ['1,0,0,0,99', '2,0,0,0,99'],
            ['2,3,0,3,99', '2,3,0,6,99'],
            ['2,4,4,5,99,0', '2,4,4,5,99,9801'],
            ['1,1,1,4,99,5,6,0,99', '30,1,1,4,2,5,6,0,99'],
            ['1101,100,-1,4,0', '1101,100,-1,4,99'],
        ];
    }

    /**
     * @dataProvider expectedOutputProvider
     */
    public function testExpectedOutput($startState, $input, $expectedOutput)
    {
        $partOne = new PartOne(explode(',', $startState), [$input]);
        $partOne->processAll();
        $this->assertEquals($expectedOutput, $partOne->getOutputs()[0]);
        $partTwo = new PartTwo(explode(',', $startState), [$input]);
        $partTwo->processAll();
        $this->assertEquals($expectedOutput, $partTwo->getOutputs()[0]);
    }

    public function expectedOutputProvider()
    {
        return [
            ['3,0,4,0,99', 77, 77],
        ];
    }

    /**
     * @dataProvider partTwoExamplesProvider
     */
    public function testPartTwoOutput($startState, $input, $expectedOutput)
    {
        $partOne = new PartTwo(explode(',', $startState), [$input]);
        $partOne->processAll();
        $this->assertEquals($expectedOutput, $partOne->getOutputs()[0]);
    }

    public function partTwoExamplesProvider()
    {
        return [
            'pos eq 8 true' => ['3,9,8,9,10,9,4,9,99,-1,8', 8, 1],
            'pos eq 8 false' => ['3,9,8,9,10,9,4,9,99,-1,8', 7, 0],
            'pos lt 8 true' => ['3,9,7,9,10,9,4,9,99,-1,8', 7, 1],
            'pos lt 8 false' => ['3,9,7,9,10,9,4,9,99,-1,8', 8, 0],
            'imm eq 8 true' => ['3,3,1108,-1,8,3,4,3,99', 8, 1],
            'imm eq 8 false' => ['3,3,1108,-1,8,3,4,3,99', 7, 0],
            'imm lt 8 true' => ['3,3,1107,-1,8,3,4,3,99', 7, 1],
            'imm lt 8 false' => ['3,3,1107,-1,8,3,4,3,99', 8, 0],
            'pos jmp eq 0 true' => ['3,12,6,12,15,1,13,14,13,4,13,99,-1,0,1,9', 0, 0],
            'pos jmp eq 0 false' => ['3,12,6,12,15,1,13,14,13,4,13,99,-1,0,1,9', 42, 1],
            'imm jmp eq 0 true' => ['3,3,1105,-1,9,1101,0,0,12,4,12,99,1', 0, 0],
            'imm jmp eq 0 false' => ['3,3,1105,-1,9,1101,0,0,12,4,12,99,1', 42, 1],
            'lt 8' => ['3,21,1008,21,8,20,1005,20,22,107,8,21,20,1006,20,31,1106,0,36,98,0,0,1002,21,125,20,4,20,1105,1,46,104,999,1105,1,46,1101,1000,1,20,4,20,1105,1,46,98,99', 7, 999],
            'eq 8' => ['3,21,1008,21,8,20,1005,20,22,107,8,21,20,1006,20,31,1106,0,36,98,0,0,1002,21,125,20,4,20,1105,1,46,104,999,1105,1,46,1101,1000,1,20,4,20,1105,1,46,98,99', 8, 1000],
            'gt 8' => ['3,21,1008,21,8,20,1005,20,22,107,8,21,20,1006,20,31,1106,0,36,98,0,0,1002,21,125,20,4,20,1105,1,46,104,999,1105,1,46,1101,1000,1,20,4,20,1105,1,46,98,99', 9, 1001],

        ];
    }

    public function testWithInputPartOne()
    {
        $partOne = new PartOne([], [1]);
        $partOne->processAll();
        $this->assertTrue(true);
        echo sprintf('Result: %s', $partOne->getOutputs()[0]);
    }

    public function testWithInputPartTwo()
    {
        $partOne = new PartTwo([], [5]);
        $partOne->processAll();
        $this->assertTrue(true);
        echo sprintf('Result: %s', $partOne->getOutputs()[0]);
    }
}