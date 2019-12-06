<?php

namespace AoC\Advent2019\Dec05;

use AoC\PartWithInput;

class PartOne extends PartWithInput
{
    /** @var array Instruction Data */
    protected $state;

    /** @var int Instruction Pointer */
    protected $ip;

    /** @var array */
    protected $inputs;

    /** @var array  */
    protected $outputs;

    public function __construct(array $inputState = [], array $inputs = [], int $ip = 0)
    {
        parent::__construct();

        $this->records->rewind();
        $data = $this->records->current();

        $this->state = count($inputState) === 0 ? $data : $inputState;
        $this->ip = $ip;
        $this->inputs = $inputs;
        $this->outputs = [];
    }

    public function processAll()
    {
        while (($result = $this->processInstruction()) !== false) {
            if ($result !== true) {
                $this->outputs[] = $result;
                echo sprintf("Output: %s\n", $result);
            }
        }
    }

    protected function process01($params)
    {
        list($pA, $pB) = $this->multiParams(2, $params);
        list($a, $b, $out) = $this->multi(3);
        $this->state[$out] = $this->getValue($a, $pA) + $this->getValue($b, $pB);
        echo sprintf("  ADD %s%s %s%s -> @%s\n", $pA, $a, $pB, $b, $out);
        echo sprintf("= ADD #%s #%s -> @%s\n", $this->getValue($a, $pA), $this->getValue($a, $pA), $out);
        return true;
    }

    protected function process02($params)
    {
        list($pA, $pB) = $this->multiParams(2, $params);
        list($a, $b, $out) = $this->multi(3);
        $this->state[$out] = $this->getValue($a, $pA) * $this->getValue($b, $pB);
        echo sprintf("  MUL %s%s %s%s -> @%s\n", $pA, $a, $pB, $b, $out);
        echo sprintf("= MUL #%s #%s -> @%s\n", $this->getValue($a, $pA), $this->getValue($a, $pA), $out);
        return true;
    }

    protected function process03($params)
    {
        $a = $this->next();
        $in = array_shift($this->inputs);
        echo sprintf("  INP #%s -> @%s\n", $in, $a);
        echo sprintf("= INP #%s -> @%s\n", $in, $a);
        $this->state[$a] = $in;
        return true;
    }

    protected function process04($params)
    {
        $a = $this->next();
        list($pA) = $this->multiParams(1, $params);
        echo sprintf("  OUT %s%s\n", $pA, $a);
        echo sprintf("  OUT #%s\n", $this->getValue($a, $pA));
        return $this->getValue($a, $pA);
    }

    protected function process99($params)
    {
        return false;
    }

    public function processInstruction()
    {
        $opCodeString = $this->state[$this->ip++];
        $opCode = substr($opCodeString, -2, 2);
        $opFunction = 'process'.str_pad($opCode, 2, '0', STR_PAD_LEFT);
        $params = str_split($opCodeString);
        array_pop($params);
        array_pop($params);
        return $this->{$opFunction}($params);
    }

    protected function next(): int
    {
        return intval($this->state[$this->ip++]);
    }

    protected function multi(int $count = 1): array
    {
        $values = [];
        for($i = 0; $i < $count; $i++) {
            $values[] = $this->next();
        }
        return $values;
    }

    protected function multiParams(int $count = 1, $params = []): array
    {
        $newParams = [];
        for ($i = 0; $i < $count; $i++) {
            $newParams[] = array_pop($params) == '1' ? '#' : '@';
        }
        return $newParams;
    }

    protected function getValue($addr, $mode = '0'): int
    {
        switch ($mode) {
            case '0':
            case null:
            case '@':
                return intval($this->state[$addr]);
            case '1':
            case '#':
                return intval($addr);
            default:
                throw new \Exception('Unkown Mode');
        }
    }

    public function runWithInput()
    {
        $this->records->rewind();
        $data = $this->records->current();
        $partOne = new static(explode(',', $data), [1]);
        $partOne->processAll();
        return $partOne->getOutputs()[0];
    }

    public function getState(): array
    {
        return $this->state;
    }

    public function getOutputs()
    {
        return $this->outputs;
    }
}
