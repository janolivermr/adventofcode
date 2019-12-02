<?php

namespace AoC\Advent2019\Dec02;

class PartTwo extends PartOne
{
    public function __invoke()
    {
        $this->records->rewind();
        $data = $this->records->current();
        for ($noun = 0; $noun <= 99; $noun++) {
            for ($verb = 0; $verb <= 99; $verb++) {
                $data[1] = $noun;
                $data[2] = $verb;
                $result = self::processCode($data);
                if ($result[0] === 19690720) {
                    return 100 * $noun + $verb;
                }
            }
        }
        throw new \Exception('No result found!');
    }
}
