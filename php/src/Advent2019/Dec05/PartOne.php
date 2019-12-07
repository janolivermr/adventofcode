<?php

namespace AoC\Advent2019\Dec05;

class PartOne
{
    /** @var array Memory State */
    protected array $state;

    /** @var int Instruction Pointer */
    protected int $ip;

    /** @var array */
    protected array $inputs;

    /** @var array */
    protected array $outputs = [];

    public function __construct(array $inputState, array $inputs = [], int $ip = 0)
    {
        $this->state = $inputState;
        $this->ip = $ip;
        $this->inputs = $inputs;
    }

    public function processAll()
    {
        while (($result = $this->processInstruction()) !== false) {
            if ($result !== true) {
                echo_dbg(sprintf("Output: %s\n", $result), 4);
            }
        }
    }

    protected function process01($params)
    {
        list($pA, $pB) = $this->multiParams(2, $params);
        list($a, $b, $out) = $this->multi(3);
        $this->state[$out] = $this->getValue($a, $pA) + $this->getValue($b, $pB);
        echo_dbg(sprintf("  ADD %s%s %s%s -> @%s\n", $pA, $a, $pB, $b, $out));
        echo_dbg(sprintf("= ADD #%s #%s -> @%s\n", $this->getValue($a, $pA), $this->getValue($a, $pA), $out));
        return true;
    }

    protected function process02($params)
    {
        list($pA, $pB) = $this->multiParams(2, $params);
        list($a, $b, $out) = $this->multi(3);
        $this->state[$out] = $this->getValue($a, $pA) * $this->getValue($b, $pB);
        echo_dbg(sprintf("  MUL %s%s %s%s -> @%s\n", $pA, $a, $pB, $b, $out));
        echo_dbg(sprintf("= MUL #%s #%s -> @%s\n", $this->getValue($a, $pA), $this->getValue($a, $pA), $out));
        return true;
    }

    protected function process03($params)
    {
        $a = $this->next();
        $in = array_shift($this->inputs);
        echo_dbg(sprintf("  INP #%s -> @%s\n", $in, $a));
        echo_dbg(sprintf("= INP #%s -> @%s\n", $in, $a));
        $this->state[$a] = $in;
        return true;
    }

    protected function process04($params)
    {
        $a = $this->next();
        list($pA) = $this->multiParams(1, $params);
        echo_dbg(sprintf("  OUT %s%s\n", $pA, $a));
        echo_dbg(sprintf("  OUT #%s\n", $this->getValue($a, $pA)));
        $output = $this->getValue($a, $pA);
        $this->outputs[] = $output;
        return $output;
    }

    protected function process99($params)
    {
        echo_dbg("  HLT\n");
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
                throw new \Exception('Unknown Mode');
        }
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
