<?php

namespace AoC\Advent2019\Dec01;

class PartTwo extends PartOne
{
    public static function calculateFuelRecursive($mass)
    {
        $fuel = self::calculateFuel($mass);
        if ($fuel <= 0) {
            return 0;
        }
        return $fuel + self::calculateFuelRecursive($fuel);
    }

    public function __invoke()
    {
        $fuelRequired = 0;
        foreach ($this->records as $record) {
            $fuelRequired += self::calculateFuelRecursive((int)$record[0]);
        }
        return $fuelRequired;
    }
}
