<?php

namespace AoC\Advent2019\Dec04;

use AoC\PartWithInput;

class PartOne extends PartWithInput
{
    public static function hasTwoFollowingDigits($passwordChars): bool
    {
        $result = false;
        for ($i = 0; $i < (count($passwordChars)-1); $i++) {
            $result = $result || ($passwordChars[$i] == $passwordChars[$i + 1]);
        }
        return $result;
    }

    public static function isIncreasing($passwordChars): bool
    {
        $result = true;
        for ($i = 0; $i < (count($passwordChars)-1); $i++) {
            $result = $result && ($passwordChars[$i] <= $passwordChars[$i + 1]);
        }
        return $result;
    }

    public static function isValidPassword($password)
    {
        $valid = true;
        $chars = str_split($password);
        $valid = $valid && self::hasTwoFollowingDigits($chars);
        $valid = $valid && self::isIncreasing($chars);
        return $valid;
    }

    public function __invoke()
    {
        $this->records->rewind();
        $range = $this->records->current();
        list($start, $end) = explode('-', $range[0]);
        $count = 0;
        for ($pw = (int)$start; $pw < (int)$end; $pw++) {
            if (static::isValidPassword((string)$pw)) {
                $count++;
            }
        }
        return $count;
    }
}
