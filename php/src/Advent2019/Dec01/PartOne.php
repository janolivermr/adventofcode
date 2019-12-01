<?php

namespace AoC\Advent2019\Dec01;

use AoC\PartWithInput;

class PartOne extends PartWithInput
{
    public static function calculateFuel($mass)
    {
        return floor((int)$mass / 3) - 2;
    }

    public function __invoke()
    {
        $fuelRequired = 0;
        foreach ($this->records as $record) {
            $fuelRequired += self::calculateFuel((int)$record[0]);
        }
        return $fuelRequired;
    }
}
