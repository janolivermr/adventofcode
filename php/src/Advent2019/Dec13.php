<?php

namespace AoC\Advent2019;

class Dec13 extends Dec11
{
    public const ARCADE_TILE_ID_EMPTY = 0;
    public const ARCADE_TILE_ID_WALL = 1;
    public const ARCADE_TILE_ID_BLOCK = 2;
    public const ARCADE_TILE_ID_HPADDLE = 3;
    public const ARCADE_TILE_ID_BALL = 4;
    protected array $arcadeGrid = [];

    protected function getInput()
    {
        $ballColumn = false;
        $paddleColumn = false;
        foreach ($this->arcadeGrid as $row) {
            foreach ($row as $x => $tile) {
                if ($tile === self::ARCADE_TILE_ID_BALL) {
                    $ballColumn = $x;
                } elseif ($tile === self::ARCADE_TILE_ID_HPADDLE) {
                    $paddleColumn = $x;
                }
            }
        }
        return $ballColumn <=> $paddleColumn;
    }

    public function runArcadeGame()
    {
        $x = $this->processToFirstOutput();
        do {
            $y = $this->processToFirstOutput();
            $type = $this->processToFirstOutput();
            if (!array_key_exists($y, $this->arcadeGrid)) {
                $this->arcadeGrid[$y] = [];
            }
            $this->arcadeGrid[$y][$x] = $type;
            $x = $this->processToFirstOutput();
        } while ($x !== false);
    }

    public function getArcadeGrid()
    {
        return $this->arcadeGrid;
    }
}