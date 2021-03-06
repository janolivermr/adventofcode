<?php

namespace AoC\Advent2019;

class Dec03
{
    /** @var array */
    protected array $grid;

    public function __construct()
    {
        $this->grid = [];
    }

    public function addWireLines($input, $name)
    {
        $x = 0;
        $y = 0;
        $wireLength = 0;
        foreach ($input as $instruction) {
            $direction = substr($instruction, 0, 1);
            $count = substr($instruction, 1);
            while ($count > 0) {
                $count--;
                $wireLength++;
                switch ($direction) {
                    case 'U':
                        $y++;
                        break;
                    case 'L':
                        $x--;
                        break;
                    case 'D':
                        $y--;
                        break;
                    case 'R':
                        $x++;
                        break;
                    default:
                        throw new \Exception('No instruction');
                }
                $location = sprintf('X%sY%s', $x, $y);
                if (!isset($this->grid[$location])) {
                    $this->grid[$location] = [
                        'wires' => [],
                        'distance' => (abs($x) + abs($y)),
                    ];
                }
                if (!isset($this->grid[$location]['wires'][$name])) {
                    $this->grid[$location]['wires'][$name] = $wireLength;
                }
            }
        }
    }

    public function getClosestCrossingPoint($wireOne, $wireTwo): int
    {
        $this->addWireLines($wireOne, 'A');
        $this->addWireLines($wireTwo, 'B');
        $shortest = null;
        foreach ($this->grid as $location) {
            if(count($location['wires']) > 1) {
                $shortest === null ? $shortest = $location['distance'] : $shortest = min($shortest, $location['distance']);
            }
        }
        return $shortest;
    }

    public function getShortestWireLength($wireOne, $wireTwo): int
    {
        $this->addWireLines($wireOne, 'A');
        $this->addWireLines($wireTwo, 'B');
        $shortest = null;
        foreach ($this->grid as $location) {
            if(count($location['wires']) > 1) {
                $combinedLength = $location['wires']['A'] + $location['wires']['B'];
                $shortest === null ? $shortest = $combinedLength : $shortest = min($shortest, $combinedLength);
            }
        }
        return $shortest;
    }
}