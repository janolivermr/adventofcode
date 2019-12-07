<?php

namespace AoC\Advent2019\Dec07;

class PartOne extends \AoC\Advent2019\Dec05\PartTwo
{
    public static function calculateMaxAmp(array $inputState, $input = 0, $phaseInputs = [0, 1, 2, 3, 4]): int
    {
        $outputs = [];
        foreach ($phaseInputs as $phaseInput) {
            $computer = new static($inputState, [$phaseInput, $input]);
            $output = $computer->processToFirstOutput();
            $newPhaseInputs = array_diff($phaseInputs, [$phaseInput]);
            if (count($newPhaseInputs) === 0) {
                return $output;
            }
            $outputs[] = self::calculateMaxAmp($inputState, $output, array_diff($phaseInputs, [$phaseInput]));
        }
        sort($outputs, SORT_NUMERIC);
        return end($outputs);
    }

    public function processToFirstOutput()
    {
        do {
            $result = $this->processInstruction();
        } while($result === true);

        return $result;
    }
}
