<?php

namespace AoC\Advent2019\Dec05;

class PartTwo extends PartOne
{
    protected function process05($params)
    {
        list($pA, $pB) = $this->multiParams(2, $params);
        list($a, $b) = $this->multi(2);
        echo_dbg(sprintf("  JNZ %s%s => %s%s\n", $pA, $a, $pB, $b));
        echo_dbg(sprintf("= JNZ #%s => #%s\n", $this->getValue($a, $pA), $this->getValue($a, $pA)));
        if ($this->getValue($a, $pA) !== 0) {
            $newAddr = $this->getValue($b, $pB);
            echo_dbg(sprintf("--------> %s\n", $newAddr));
            $this->ip = $newAddr;
        }
        return true;
    }

    protected function process06($params)
    {
        list($pA, $pB) = $this->multiParams(2, $params);
        list($a, $b) = $this->multi(2);
        echo_dbg(sprintf("  JPZ %s%s => %s%s\n", $pA, $a, $pB, $b));
        echo_dbg(sprintf("= JPZ #%s => #%s\n", $this->getValue($a, $pA), $this->getValue($a, $pA)));
        if ($this->getValue($a, $pA) === 0) {
            $newAddr = $this->getValue($b, $pB);
            echo_dbg(sprintf("--------> %s\n", $newAddr));
            $this->ip = $newAddr;
        }
        return true;
    }

    protected function process07($params)
    {
        list($pA, $pB) = $this->multiParams(2, $params);
        list($a, $b) = $this->multi(2);
        echo_dbg(sprintf("  LES %s%s %s%s\n", $pA, $a, $pB, $b));
        echo_dbg(sprintf("= LES #%s #%s\n", $this->getValue($a, $pA), $this->getValue($a, $pA)));
        $this->state[$this->next()] = $this->getValue($a, $pA) < $this->getValue($b, $pB) ? 1 : 0;
        return true;
    }

    protected function process08($params)
    {
        list($pA, $pB) = $this->multiParams(2, $params);
        list($a, $b) = $this->multi(2);
        echo_dbg(sprintf("  EQU %s%s %s%s\n", $pA, $a, $pB, $b));
        echo_dbg(sprintf("= EQU #%s #%s\n", $this->getValue($a, $pA), $this->getValue($a, $pA)));
        $this->state[$this->next()] = $this->getValue($a, $pA) == $this->getValue($b, $pB) ? 1 : 0;
        return true;
    }
}
