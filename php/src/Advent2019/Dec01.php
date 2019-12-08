<?php

namespace AoC\Advent2019;

class Dec01
{
    public static function calculateFuel($mass)
    {
        return floor((int)$mass / 3) - 2;
    }

    public static function calculateFuelRecursive($mass)
    {
        $fuel = self::calculateFuel($mass);
        if ($fuel <= 0) {
            return 0;
        }
        return $fuel + self::calculateFuelRecursive($fuel);
    }
}