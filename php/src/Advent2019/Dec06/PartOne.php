<?php

namespace AoC\Advent2019\Dec06;

use AoC\PartWithInput;

class PartOne extends PartWithInput
{
    protected $planets;

    public function __construct(array $map = null)
    {
        parent::__construct();

        $this->planets = [];

        foreach ($map ?? $this->records as $record) {
            list($inner, $outer) = explode(')', $record[0]);
            $this->planets[$outer] = $inner;
        }
    }

    public function getOrbitCount($planet)
    {
        $orbits = 1;
        if ($this->planets[$planet] !== 'COM') {
            $orbits += $this->getOrbitCount($this->planets[$planet]);
        }
        return $orbits;
    }

    public function getOrbitTotal()
    {
        $total = 0;
        foreach ($this->planets as $planet => $parent) {
            $total += $this->getOrbitCount($planet);
        }
        return $total;
    }
}
