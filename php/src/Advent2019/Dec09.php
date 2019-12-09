<?php

namespace AoC\Advent2019;

class Dec09 extends Dec07
{
    protected int $relativeBase = 0;

    protected function process09()
    {
        $a = $this->nextValue();
        $this->relativeBase = $this->relativeBase + $a;
        echo_dbg(sprintf("  REL #%s = #%s\n", $a, $this->relativeBase));
        return true;
    }

    protected function nextValue(): int
    {
        $mode = array_pop($this->modes);
        switch ($mode) {
            case '2':
                return intval($this->getOffset($this->relativeBase + $this->next()));
            case '1':
                return intval($this->next());
            case '0':
            default:
                return intval($this->getOffset($this->next()));
        }
    }

    protected function nextAddress(): int
    {
        $mode = array_pop($this->modes);
        switch ($mode) {
            case '2':
                return $this->relativeBase + $this->next();
            case '0':
            default:
                return $this->next();
        }
    }
}