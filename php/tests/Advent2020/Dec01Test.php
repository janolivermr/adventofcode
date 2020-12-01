<?php

namespace Tests\Advent2020;

use AoC\Advent2020\Dec01;
use Tests\TestCaseWithInput;

class Dec01Test extends TestCaseWithInput
{
    /**
     * @dataProvider sampleDataProvider
     */
    public function testPartOneExample($sample)
    {
        $this->assertEquals(514579, Dec01::calculateTwoNumberExpense($sample));
    }

    /**
     * @dataProvider sampleDataProvider
     */
    public function testPartTwoExample($sample)
    {
        $this->assertEquals(241861950, Dec01::calculateThreeNumberExpense($sample));
    }

    public function runPartOne()
    {
        $data = array_map(function ($record) {
            return $record[0];
        }, iterator_to_array($this->getInput()));
        return Dec01::calculateTwoNumberExpense($data);
    }

    public function runPartTwo()
    {
        $data = array_map(function ($record) {
            return $record[0];
        }, iterator_to_array($this->getInput()));
        return Dec01::calculateThreeNumberExpense($data);
    }

    public function sampleDataProvider()
    {
        return [
            'sample' => [[1721, 979, 366, 299, 675, 1456]],
        ];
    }
}
