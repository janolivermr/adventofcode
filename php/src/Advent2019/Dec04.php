<?php

namespace AoC\Advent2019;

class Dec04
{
    /** @var int */
    protected int $start;

    /** @var int */
    protected int $end;

    public function __construct(string $range)
    {
        list($this->start, $this->end) = explode('-', $range);
    }

    public static function hasTwoFollowingDigits(array $passwordChars): bool
    {
        $result = false;
        for ($i = 0; $i < (count($passwordChars)-1); $i++) {
            $result = $result || ($passwordChars[$i] == $passwordChars[$i + 1]);
        }
        return $result;
    }

    public static function isIncreasing(array $passwordChars): bool
    {
        $result = true;
        for ($i = 0; $i < (count($passwordChars)-1); $i++) {
            $result = $result && ($passwordChars[$i] <= $passwordChars[$i + 1]);
        }
        return $result;
    }

    private static function hasExactlyTwoFollowingDigits(array $passwordChars)
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

    public static function isValidPassword(string $password, bool $strict = false)
    {
        $chars = str_split($password);
        if ($strict) {
            return self::isIncreasing($chars) && self::hasExactlyTwoFollowingDigits($chars);
        } else {
            return self::isIncreasing($chars) && self::hasTwoFollowingDigits($chars);
        }
    }

    public function getValidPasswords($strict = false)
    {
        $count = 0;
        for ($pw = $this->start; $pw < $this->end; $pw++) {
            if (self::isValidPassword((string)$pw, $strict)) {
                $count++;
            }
        }
        return $count;
    }
}