<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec11;
use Tests\TestCaseWithInput;

class Dec11Test extends TestCaseWithInput
{
    public function runPartOne()
    {
        $inputState = iterator_to_array($this->getInput())[0];
        $dec11 = new Dec11($inputState);
        do {
            $result = $dec11->runOnePaintCycle();
        } while ($result === true);
        return $dec11->getPaintedPanelsCount();
    }

    public function runPartTwo()
    {
        $inputState = iterator_to_array($this->getInput())[0];
        $dec11 = new Dec11($inputState);
        $dec11->setStartPanelColor(Dec11::WHITE);
        do {
            $result = $dec11->runOnePaintCycle();
        } while ($result === true);
        return $dec11->getHullArray();
    }
}