<?php

namespace AoC\Advent2019\Dec06;

class PartTwo extends PartOne
{
    public function getOrbitCount($planet)
    {
        return count($this->getParentOrbits($planet));
    }

    public function getParentOrbits($planet)
    {
        $parents = [$this->planets[$planet]];
        if ($this->planets[$planet] !== 'COM') {
            $parents = array_merge($parents, $this->getParentOrbits($this->planets[$planet]));
        }
        return $parents;
    }

    public function getOrbitTransfers($origin, $destination)
    {
        $originSteps = $this->getParentOrbits($origin);
        $destinationSteps = $this->getParentOrbits($destination);
        $sharedSteps = array_intersect($originSteps, $destinationSteps);
        return count($originSteps) + count($destinationSteps) - 2 * count($sharedSteps);
    }
}
