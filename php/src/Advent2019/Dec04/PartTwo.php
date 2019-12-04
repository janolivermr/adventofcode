<?php

namespace AoC\Advent2019\Dec04;

use AoC\PartWithInput;

class PartTwo extends PartOne
{
    private static function hasExactlyTwoFollowingDigits($passwordChars)
    {
        $numberCounts = [];
        for ($i = 0; $i < count($passwordChars); $i++) {
            $numberCounts[$passwordChars[$i]] = ($numberCounts[$passwordChars[$i]] ?? 0) + 1;
        }
        $result = false;
        foreach ($numberCounts as $numberCount) {
            $result = $result || $numberCount == 2;
        }
        return $result;
    }

    public static function isValidPassword($password)
    {
        $valid = true;
        $chars = str_split($password);
        $valid = $valid && self::hasExactlyTwoFollowingDigits($chars);
        $valid = $valid && self::isIncreasing($chars);
        return $valid;
    }
}
