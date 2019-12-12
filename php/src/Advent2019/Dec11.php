<?php

namespace AoC\Advent2019;

class Dec11 extends Dec09
{
    const UP = 0;
    const LEFT = 1;
    const DOWN = 2;
    const RIGHT = 3;

    const BLACK = 0;
    const WHITE = 1;

    /** @var array X, Y and direction */
    protected array $robotPosition = [0, 0, self::UP];

    /** @var array Hull color array */
    protected array $hullColors = [
        [self::BLACK],
    ];

    public function setStartPanelColor(int $color = self::BLACK)
    {
        $this->hullColors[0][0] = $color;
    }

    public function getHullArray()
    {
        $xMin = 0;
        $xMax = 0;
        foreach ($this->hullColors as $row) {
            $xMin = min($xMin, min(array_keys($row)));
            $xMax = max($xMax, max(array_keys($row)));
        }
        arsort($this->hullColors, SORT_NUMERIC);
        $result = "\n";
        foreach ($this->hullColors as $row) {
            for ($i = $xMin; $i <= $xMax; $i++) {
                $result .= ($row[$i] ?? self::BLACK) === self::WHITE ? 'X' : ' ';
            }
            $result .= "\n";
        }
        return $result;
    }

    public function runOnePaintCycle()
    {
        // Add current color to input
        $this->addInput($this->hullColors[$this->robotPosition[1]][$this->robotPosition[0]] ?? self::BLACK);
        $paintColor = $this->processToFirstOutput();
        if ($paintColor === false) {
            return false;
        }
        $turnDirection = $this->processToFirstOutput();
        if ($turnDirection === false) {
            return false;
        }
        $this->hullColors[$this->robotPosition[1]][$this->robotPosition[0]] = $paintColor === 0 ? self::BLACK : self::WHITE;
        // Left: 0-0.5 = -0.5 | -0.5*2 = -1 | -(-1) = 1 -> add this to current direction
        $turnValue = -intval(2*($turnDirection-0.5));
        $this->robotPosition[2] = (4 + $this->robotPosition[2] + $turnValue) % 4;
        switch ($this->robotPosition[2]) {
            case self::UP:
                $this->robotPosition[1] = $this->robotPosition[1] + 1;
                break;
            case self::LEFT:
                $this->robotPosition[0] = $this->robotPosition[0] - 1;
                break;
            case self::DOWN:
                $this->robotPosition[1] = $this->robotPosition[1] - 1;
                break;
            case self::RIGHT:
                $this->robotPosition[0] = $this->robotPosition[0] + 1;
                break;
            default:
                throw new \Exception('This should not be reached');
        }
        if (!array_key_exists($this->robotPosition[1], $this->hullColors)) {
            $this->hullColors[$this->robotPosition[1]] = [];
        }
        return true;
    }

    public function getPaintedPanelsCount()
    {
        $count = 0;
        foreach ($this->hullColors as $row) {
            $count = $count + count($row);
        }
        return $count;
    }
}