<?php

namespace AoC\Advent2019;

class Dec05 extends Dec02
{
    /** @var array */
    protected array $inputs;

    /** @var array */
    protected array $outputs = [];

    /** @var array */
    protected array $modes = [];

    public function __construct(array $inputState, array $inputs = [])
    {
        parent::__construct($inputState);
        $this->inputs = $inputs;
    }

    protected function process03()
    {
        $input = array_shift($this->inputs);
        $writeAddr = $this->nextAddress();
        $this->write($writeAddr, $input);
        echo_dbg(sprintf("  INP #%s -> @%s\n", $input, $writeAddr));
        return true;
    }

    protected function process04()
    {
        $output = $this->nextValue();
        $this->outputs[] = $output;
        echo_dbg(sprintf("  OUT #%s\n", $output));
        return $output;
    }

    protected function process05()
    {
        $a = $this->nextValue();
        $jmpDest = $this->nextValue();
        if ($a !== 0) {
            echo_dbg(sprintf("--------> %s\n", $jmpDest));
            $this->ip = $jmpDest;
        }
        echo_dbg(sprintf("  JNZ #%s => #%s\n", $a, $jmpDest));
        return true;
    }

    protected function process06()
    {
        $a = $this->nextValue();
        $jmpDest = $this->nextValue();
        if ($a === 0) {
            echo_dbg(sprintf("--------> %s\n", $jmpDest));
            $this->ip = $jmpDest;
        }
        echo_dbg(sprintf("  JPZ #%s => #%s\n", $a, $jmpDest));
        return true;
    }

    protected function process07()
    {
        $a = $this->nextValue();
        $b = $this->nextValue();
        $outAddr = $this->nextAddress();
        echo_dbg(sprintf("  LES #%s #%s -> %s\n", $a, $b, $outAddr));
        $this->write($outAddr, $a < $b ? 1 : 0);
        return true;
    }

    protected function process08()
    {
        $a = $this->nextValue();
        $b = $this->nextValue();
        $outAddr = $this->nextAddress();
        echo_dbg(sprintf("  EQU #%s #%s -> %s\n", $a, $b, $outAddr));
        $this->write($outAddr, $a == $b ? 1 : 0);
        return true;
    }

    public function processInstruction()
    {
        $opCodeString = $this->next();
        $opCodeParts = str_split($opCodeString);
        $opCode = array_pop($opCodeParts);
        $opCode = (array_pop($opCodeParts) ?? '0').$opCode;
        $this->modes = $opCodeParts;
        $opFunction = 'process'.str_pad($opCode, 2, '0', STR_PAD_LEFT);
        return $this->{$opFunction}();
    }

    protected function nextValue(): int
    {
        if (array_pop($this->modes) === '1') {
            return intval($this->next());
        }
        return intval($this->getOffset($this->next()));
    }

    public function getOutputs()
    {
        return $this->outputs;
    }
}