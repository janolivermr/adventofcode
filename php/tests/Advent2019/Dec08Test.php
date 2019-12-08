<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec08;
use Tests\TestCaseWithInput;

class Dec08Test extends TestCaseWithInput
{
    public function testPartOneExample()
    {
        $dec08 = new Dec08('123456789012', 3, 2);
        $dec08->decodeToLayers();
        $this->assertEquals([[
            [1, 2, 3],
            [4, 5, 6],
        ], [
            [7, 8, 9],
            [0, 1, 2],
        ]], $dec08->getLayers());
    }

    public function testPartTwoExample()
    {
        $dec08 = new Dec08('0222112222120000', 2, 2);
        $dec08->decodeToLayers();
        $this->assertEquals([[
            [0, 2],
            [2, 2],
        ], [
            [1, 1],
            [2, 2],
        ], [
            [2, 2],
            [1, 2],
        ], [
            [0, 0],
            [0, 0],
        ]], $dec08->getLayers());
        $this->assertEquals("01\n10", $dec08->renderImage());
    }
    public function runPartOne()
    {
        $dec08 = new Dec08(iterator_to_array($this->getInput())[0][0], 25, 6);
        $dec08->decodeToLayers();
        return $dec08->calculateChecksum();
    }

    public function runPartTwo()
    {
        $dec08 = new Dec08(iterator_to_array($this->getInput())[0][0], 25, 6);
        $dec08->decodeToLayers();
        return "\n".$dec08->renderImage();
    }
}