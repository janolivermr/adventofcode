<?php

namespace AoC\Advent2020;

class Dec01
{
    public static function calculateTwoNumberExpense(array $data): int
    {
        $last = count($data) - 1;
        for ($i = 0; $i < $last; $i++) {
            for ($j = $i + 1; $j < $last; $j++) {
                if ($data[$i] + $data[$j] === 2020) {
                    return $data[$i] * $data[$j];
                }
            }
        }
    }

    public static function calculateThreeNumberExpense(array $data): int
    {
        $last = count($data) - 1;
        for ($i = 0; $i < $last; $i++) {
            for ($j = $i + 1; $j < $last; $j++) {
                for ($k = $j + 1; $k < $last; $k++) {
                    if ($data[$i] + $data[$j] + $data[$k] === 2020) {
                        return $data[$i] * $data[$j] * $data[$k];
                    }
                }
            }
        }
    }
}