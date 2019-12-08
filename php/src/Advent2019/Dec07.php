<?php

namespace AoC\Advent2019;

class Dec07 extends Dec05
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

    public static function calculatePhaseInputs(array $phaseInputs): array
    {
        $results = [];
        foreach ($phaseInputs as $phaseInput) {
            $result = [$phaseInput];
            $newPhaseInputs = array_diff($phaseInputs, [$phaseInput]);
            if (count($newPhaseInputs) === 0) {
                return [$result];
            }
            $innerResults = self::calculatePhaseInputs($newPhaseInputs);
            foreach ($innerResults as $innerResult) {
                $results[] = array_merge($result, $innerResult);
            }
        }
        return $results;
    }

    public function addInput(int $value)
    {
        $this->inputs[] = $value;
    }

    public static function calculateAmpWithFeedback(array $inputState, array $phaseInput, $input = 0): int
    {
        echo_dbg(var_export($phaseInput, true)."\n", 1);
        $computers = [
            new static($inputState, [$phaseInput[0]]),
            new static($inputState, [$phaseInput[1]]),
            new static($inputState, [$phaseInput[2]]),
            new static($inputState, [$phaseInput[3]]),
            new static($inputState, [$phaseInput[4]]),
        ];
        $computerInput = $input;
        for ($i = 0; $computerInput !== false; $i = ($i + 1) % 5) {
            echo_dbg(sprintf("Computer %c executing with input %s\n", $i+65, $computerInput), 1);
            $computers[$i]->addInput($computerInput);
            $computerInput = $computers[$i]->processToFirstOutput();
        }
        $output = $computers[4]->getOutputs();
        return end($output);
    }

    public static function calculateMaxAmpWithFeedback(array $inputState, array $phaseInputCombinations, $input = 0): int
    {
        $outputs = [];
        foreach ($phaseInputCombinations as $phaseInputCombination) {
            $outputs[] = self::calculateAmpWithFeedback($inputState, $phaseInputCombination, $input);
        }
        sort($outputs, SORT_NUMERIC);
        return end($outputs);
    }
}