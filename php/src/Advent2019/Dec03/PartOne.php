<?php

namespace AoC\Advent2019\Dec03;

use AoC\PartWithInput;

class PartOne extends PartWithInput
{
    protected array $grid;

    public function __construct()
    {
        parent::__construct();
        $this->grid = [];
    }

    public function addWireLines($input, $name)
    {
        $x = 0;
        $y = 0;
        foreach ($input as $instruction) {
            $direction = substr($instruction, 0, 1);
            $count = substr($instruction, 1);
            while ($count > 0) {
                $count--;
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
                if(isset($this->grid[$location])) {
                    $this->grid[$location]['wires'] = array_unique(array_merge($this->grid[$location]['wires'], [$name]));
                } else {
                    $this->grid[$location] = [
                        'wires' => [$name],
                        'distance' => (abs($x) + abs($y)),
                    ];
                }
            }
        }
    }

    public function __invoke()
    {
        ini_set('memory_limit','-1');
        $this->records->rewind();
        $wireOne = $this->records->current();
        $this->records->next();
        $wireTwo = $this->records->current();
        return $this->getClosestCrossingPoint($wireOne, $wireTwo);
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
}
