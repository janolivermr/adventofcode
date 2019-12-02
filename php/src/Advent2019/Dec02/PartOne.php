<?php

namespace AoC\Advent2019\Dec02;

use AoC\PartWithInput;

class PartOne extends PartWithInput
{
    public static function processCode(array $data): array
    {
        $ip = 0;
        while ($ip < count($data) && ($opCode = intval($data[$ip++])) !== 99 ) {
            $a = intval($data[$ip++]);
            $b = intval($data[$ip++]);
            $out = intval($data[$ip++]);
            switch ($opCode) {
                case 1:
                    $data[$out] = intval($data[$a]) + intval($data[$b]);
                    break;
                case 2:
                    $data[$out] = intval($data[$a]) * intval($data[$b]);
                    break;
                default:
                    throw new \Exception('Unexpected OpCode');
            }
        }
        return $data;
    }

    public function __invoke()
    {
        $this->records->rewind();
        $data = $this->records->current();
        $data[1] = 12;
        $data[2] = 2;
        $data = self::processCode($data);
        return $data[0];
    }
}
