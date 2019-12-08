<?php

namespace AoC\Advent2019;

class Dec02
{
    /** @var array Memory State */
    protected array $state;

    /** @var int Instruction Pointer */
    protected int $ip = 0;

    public function __construct(array $inputState)
    {
        $this->state = $inputState;
    }

    public function processAll()
    {
        do {
            $result = $this->processInstruction();
        } while ($result !== false);
    }

    protected function process01()
    {
        $a = $this->readNext();
        $b = $this->readNext();
        $outAddr = $this->next();
        $this->write($outAddr, $a + $b);
        echo_dbg(sprintf("  ADD #%s #%s -> @%s\n", $a, $b, $outAddr));
        return true;
    }

    protected function process02()
    {
        $a = $this->readNext();
        $b = $this->readNext();
        $outAddr = $this->next();
        $this->write($outAddr, $a * $b);
        echo_dbg(sprintf("  MUL #%s #%s -> @%s\n", $a, $b, $outAddr));
        return true;
    }

    protected function process99()
    {
        echo_dbg("  HLT\n");
        return false;
    }

    public function processInstruction()
    {
        $opCode = $this->next();
        $opFunction = 'process'.str_pad($opCode, 2, '0', STR_PAD_LEFT);
        return $this->{$opFunction}();
    }

    protected function next()
    {
        return $this->state[$this->ip++];
    }

    protected function readNext(): int
    {
        return intval($this->state[$this->next()]);
    }

    protected function write($addr, $value)
    {
        $this->state[$addr] = $value;
    }

    public function getState(): array
    {
        return $this->state;
    }
}