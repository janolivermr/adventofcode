<?php

namespace AoC\Advent2019;

class Dec10
{
    protected array $asteroids = [];

    public function __construct(array $inputRows)
    {
        foreach ($inputRows as $y => $inputRow) {
            $characters = str_split($inputRow);
            foreach ($characters as $x => $character) {
                if ($character === '#') {
                    $this->asteroids[] = [$x, $y];
                }
            }
        }
    }

    public function asteroidsFromPoint(int $x, int $y)
    {
        echo_dbg(sprintf("For Asteroid %s, %s:\n", $x, $y));
        $angles = [];
        foreach ($this->asteroids as $asteroid) {
            if ($asteroid === [$x, $y]) {
                continue;
            }
            $diffX = $asteroid[0] - $x;
            $diffY = $y - $asteroid[1];
            $distance = sqrt($diffX*$diffX + $diffY*$diffY);
            $angle = 1000*(360+rad2deg(atan2($diffX, $diffY)))%360000;
            echo_dbg(sprintf("Found: X%s, Y%s - (%s, %s) Dist: %s\n", $asteroid[0], $asteroid[1], $diffX, $diffY, $distance));
            if (!isset($angles[$angle])) {
                $angles[$angle] = [];
            }
            $angles[$angle][$distance] = [$asteroid[0], $asteroid[1]];
            ksort($angles[$angle]);
        }
        ksort($angles);
        return $angles;
    }

    public function maxAsteroidsVisible()
    {
        $visCounts = $this->visibilityCounts();
        return max(array_keys($visCounts));
    }

    public function visibilityCounts()
    {
        $counts = [];
        foreach ($this->asteroids as $asteroid) {
            $counts[count($this->asteroidsFromPoint($asteroid[0], $asteroid[1]))] = [$asteroid[0], $asteroid[1]];
        }
        ksort($counts);
        return $counts;
    }

    public function getNthShotAsteroidCoords(int $n)
    {
        $visCounts = $this->visibilityCounts();
        list($x, $y) = end($visCounts);
        $angles = $this->asteroidsFromPoint($x, $y);
        $shot = 0;
        $last = [];
        while (true) {
            foreach ($angles as $angle => $asteroids) {
                if (count($asteroids) < 1) {
                    unset($angles[$angle]);
                } else {
                    $last = array_shift($angles[$angle]);
                    $shot++;
                }
                if ($shot === $n) {
                    return $last;
                }
            }
        }
        return false;
    }
}