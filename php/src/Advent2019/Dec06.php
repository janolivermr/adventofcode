<?php

namespace AoC\Advent2019;

class Dec06
{
    protected $planets;

    public function __construct(array $map)
    {
        foreach ($map as $record) {
            list($inner, $outer) = explode(')', $record);
            $this->planets[$outer] = $inner;
        }
    }

    public function getParentOrbits($planet)
    {
        $parents = [$this->planets[$planet]];
        if ($this->planets[$planet] !== 'COM') {
            $parents = array_merge($parents, $this->getParentOrbits($this->planets[$planet]));
        }
        return $parents;
    }

    public function getComDistance($planet)
    {
        return count($this->getParentOrbits($planet));
    }

    public function getOrbitTransfers($origin, $destination)
    {
        $originSteps = $this->getParentOrbits($origin);
        $destinationSteps = $this->getParentOrbits($destination);
        $sharedSteps = array_intersect($originSteps, $destinationSteps);
        return count($originSteps) + count($destinationSteps) - 2 * count($sharedSteps);
    }

    public function getOrbitTotal()
    {
        $total = 0;
        foreach ($this->planets as $planet => $parent) {
            $total += $this->getComDistance($planet);
        }
        return $total;
    }
}