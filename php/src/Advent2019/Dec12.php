<?php

namespace AoC\Advent2019;

class Dec12
{
    /** @var array Moons */
    protected array $moons = [];

    /** @var string Initial state */
    protected array $initial;

    /** @var int elapsed steps */
    protected $steps = 0;

    public function __construct(array $coordStrings)
    {
        foreach ($coordStrings as $coordString) {
            $this->moons[] = [
                'pos' => sscanf($coordString, '<x=%i, y=%i, z=%i>'),
                'vel' => [0, 0, 0],
            ];
        }
        $this->initial = $this->moons;
    }

    public function calculateStep()
    {
        $this->steps++;
        // Update Velocities
        foreach ($this->moons as $index => $moon) {
            foreach ($this->moons as $partnerIndex => $partnerMoon) {
                if ($partnerIndex === $index) {
                    continue;
                }
                foreach ([0, 1, 2] as $direction) {
                    $this->moons[$index]['vel'][$direction] += $partnerMoon['pos'][$direction] <=> $moon['pos'][$direction];
                }
            }
        }
        // Update Positions
        foreach ($this->moons as $index => $moon) {
            foreach ([0, 1, 2] as $direction) {
                $this->moons[$index]['pos'][$direction] += $moon['vel'][$direction];
            }
        }
    }

    public function calculateEnergy()
    {
        $energy = 0;
        foreach ($this->moons as $moon) {
            $pot = 0;
            $kin = 0;
            foreach ([0, 1, 2] as $direction) {
                $pot += abs($moon['pos'][$direction]);
                $kin += abs($moon['vel'][$direction]);
            }
            $energy += $pot * $kin;
        }
        return $energy;
    }

    public function stepsToInitialState()
    {
        $cycleLengths = [];
        do {
            $this->calculateStep();
            foreach (range(0, 2) as $direction) {
                if (isset($cycleLengths[$direction])) {
                    continue;
                }
                $equalsInitial = array_reduce(array_keys($this->moons), function ($carry, $index) use ($direction) {
                    return $carry
                        && $this->moons[$index]['vel'][$direction] === 0
                        && $this->moons[$index]['pos'][$direction] === $this->initial[$index]['pos'][$direction];
                }, true);
                if ($equalsInitial) {
                    $cycleLengths[$direction] = $this->steps;
                }
            }
        } while (count($cycleLengths) < 3);
        return self::lcm(self::lcm($cycleLengths[0], $cycleLengths[1]), $cycleLengths[2]);
    }

    public static function gcd($a, $b)
    {
        if ($a == 0)
            return $b;
        return self::gcd($b % $a, $a);
    }

    public static function lcm($a, $b)
    {
        return ($a * $b) / self::gcd($a, $b);
    }

    public function prettyPrint()
    {
        foreach ($this->moons as $moon) {
            echo_dbg(sprintf(
                "pos=<x=%s, y=%s, z=%s>, vel=<x=%s, y=%s, z=%s>\n",
                $moon['pos'][0],
                $moon['pos'][1],
                $moon['pos'][2],
                $moon['vel'][0],
                $moon['vel'][1],
                $moon['vel'][2]
            ));
        }
    }
}