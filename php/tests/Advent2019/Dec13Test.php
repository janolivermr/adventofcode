<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec13;
use Tests\TestCaseWithInput;

class Dec13Test extends TestCaseWithInput
{
    public function runPartOne()
    {
        $inputState = iterator_to_array($this->getInput())[0];
        $dec13 = new Dec13($inputState);
        $dec13->runArcadeGame();
        $grid = $dec13->getArcadeGrid();
        $blockTileCount = 0;
        foreach ($grid as $row) {
            foreach ($row as $tile) {
                if ($tile === Dec13::ARCADE_TILE_ID_BLOCK) {
                    $blockTileCount++;
                }
            }
        }
        return $blockTileCount;
    }

    public function runPartTwo()
    {
        $inputState = iterator_to_array($this->getInput())[0];
        $inputState[0] = 2;
        $dec13 = new Dec13($inputState);
        $dec13->runArcadeGame();
        $grid = $dec13->getArcadeGrid();
        return $grid[0][-1];
    }
}