<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec15;
use Tests\TestCaseWithInput;

class Dec15Test extends TestCaseWithInput
{
    public function runPartOne()
    {
        $inputState = iterator_to_array($this->getInput())[0];
        $dec15 = new Dec15($inputState);
        $dec15->exploreMapBounds();
        $dec15->buildImage();
        return $dec15->findOxygenDistance();
    }

    public function runPartTwo()
    {
        $inputState = iterator_to_array($this->getInput())[0];
        $dec15 = new Dec15($inputState);
        $dec15->exploreOxygenDistances();
        $dec15->buildImage();
        return $dec15->findOxygenDuration();
    }
}