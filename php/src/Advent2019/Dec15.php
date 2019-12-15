<?php

namespace AoC\Advent2019;

class Dec15 extends Dec09
{
    public const DROID_STATUS_WALL = 0;
    public const DROID_STATUS_GROUND = 1;
    public const DROID_STATUS_OXYGEN = 2;

    public const DROID_MOVE_N = 1;
    public const DROID_MOVE_S = 2;
    public const DROID_MOVE_W = 3;
    public const DROID_MOVE_E = 4;

    public const DROID_DIRECTION_SYMBOLS = [
        self::DROID_MOVE_N => '^',
        self::DROID_MOVE_S => 'v',
        self::DROID_MOVE_W => '<',
        self::DROID_MOVE_E => '>',
    ];

    protected array $grid = [
        0 => [
            0 => self::DROID_STATUS_GROUND,
        ],
    ];
    protected array $gridDistances = [
        0 => [
            0 => 0,
        ],
    ];
    protected array $position = [0, 0];
    protected int $steps = 0;

    public function walkStep(int $direction)
    {
//        if ($this->steps < 20) {
//            $this->buildImage(self::DROID_DIRECTION_SYMBOLS[$direction]);
//        }
        $this->steps++;
        $x = $this->position[0];
        $y = $this->position[1];
        $currentDistance = $this->gridDistances[$y][$x];
        $newX = $x;
        $newY = $y;
        if (!isset($this->grid[$newY])) {
            $this->grid[$newY] = [];
        }
        if (!isset($this->gridDistances[$newY])) {
            $this->gridDistances[$newY] = [];
        }

        switch ($direction) {
            case self::DROID_MOVE_N:
                $newY++;
                break;
            case self::DROID_MOVE_S:
                $newY--;
                break;
            case self::DROID_MOVE_W:
                $newX--;
                break;
            case self::DROID_MOVE_E:
                $newX++;
                break;
            default:
                throw new \Exception('Unknown move direction');
        }

        $this->addInput($direction);
        $result = $this->processToFirstOutput();
        switch ($result) {
            case self::DROID_STATUS_WALL:
                $this->gridDistances[$newY][$newX] = '#';
                break;
            case self::DROID_STATUS_GROUND:
            case self::DROID_STATUS_OXYGEN:
                if (isset($this->gridDistances[$newY][$newX])) {
                    $this->gridDistances[$newY][$newX] = min($this->gridDistances[$newY][$newX], $currentDistance + 1);
                } else {
                    $this->gridDistances[$newY][$newX] = $currentDistance + 1;
                }
                $this->position = [$newX, $newY];
                break;
            default:
                throw new \Exception('Unkown Droid response');
        }
        $this->grid[$newY][$newX] = $result;
        return $result;
    }

    public function exploreMapBounds()
    {
        $direction = self::DROID_MOVE_N;
        do {
            $front = $this->walkStep($direction);
        } while ($front === self::DROID_STATUS_GROUND);
        $startPosition = $this->position;
        $startDirection = $direction;
        do {
            $direction = self::turnLeft($direction);
            if ($this->walkStep($direction) === self::DROID_STATUS_WALL) {
                continue;
            }
            $direction = self::turnRight($direction);
            if ($this->walkStep($direction) === self::DROID_STATUS_WALL) {
                continue;
            }
            $direction = self::turnRight($direction);
        } while (!($direction == $startDirection && $this->position == $startPosition));
    }

    public function exploreOxygenDistances()
    {
        $direction = self::DROID_MOVE_N;
        do {
            $front = $this->walkStep($direction);
        } while ($front === self::DROID_STATUS_GROUND);
        $startPosition = $this->position;
        $startDirection = $direction;
        do {
            $direction = self::turnLeft($direction);
            $status = $this->walkStep($direction);
            if ($status === self::DROID_STATUS_WALL) {
                continue;
            } elseif ($status === self::DROID_STATUS_OXYGEN) {
                break;
            }
            $direction = self::turnRight($direction);
            $status = $this->walkStep($direction);
            if ($status === self::DROID_STATUS_WALL) {
                continue;
            } elseif ($status === self::DROID_STATUS_OXYGEN) {
                break;
            }
            $direction = self::turnRight($direction);
        } while (!($direction == $startDirection && $this->position == $startPosition));

        $this->gridDistances = [
            $this->position[1] => [
                $this->position[0] => 0
            ]
        ];

        $startPosition = $this->position;
        $startDirection = $direction;
        do {
            $direction = self::turnLeft($direction);
            $status = $this->walkStep($direction);
            if ($status === self::DROID_STATUS_WALL) {
                continue;
            }
            $direction = self::turnRight($direction);
            $status = $this->walkStep($direction);
            if ($status === self::DROID_STATUS_WALL) {
                continue;
            }
            $direction = self::turnRight($direction);
        } while (!($direction == $startDirection && $this->position == $startPosition));
    }

    protected static function turnRight(int $direction)
    {
        switch ($direction) {
            case self::DROID_MOVE_N:
                return self::DROID_MOVE_E;
            case self::DROID_MOVE_E:
                return self::DROID_MOVE_S;
            case self::DROID_MOVE_S:
                return self::DROID_MOVE_W;
            case self::DROID_MOVE_W:
                return self::DROID_MOVE_N;
            default:
                return $direction;
        }
    }

    protected static function turnLeft(int $direction)
    {
        switch ($direction) {
            case self::DROID_MOVE_N:
                return self::DROID_MOVE_W;
            case self::DROID_MOVE_W:
                return self::DROID_MOVE_S;
            case self::DROID_MOVE_S:
                return self::DROID_MOVE_E;
            case self::DROID_MOVE_E:
                return self::DROID_MOVE_N;
            default:
                return $direction;
        }
    }

    public function buildImage($indicator = '+')
    {
//        dd($this->grid);
        $attribute = 'gridDistances';
        $image = [];
        $minY = min(array_keys($this->{$attribute}));
        $maxY = max(array_keys($this->{$attribute}));
        $minX = 0;
        $maxX = 0;
        $posX = $this->position[0];
        $posY = $this->position[1];
        for ($y = $minY; $y <= $maxY; $y++) {
            $minX = min($minX, min(array_keys($this->{$attribute}[$y])));
            $maxX = max($maxX, max(array_keys($this->{$attribute}[$y])));
        }
        echo_dbg(sprintf("\nY: %s < %s\nX: %s < %s\n", $minY, $maxY, $minX, $maxX));
        for ($y = $minY; $y <= $maxY; $y++) {
            $row = '';
            for ($x = $minX; $x <= $maxX; $x++) {
                if ($posX == $x && $posY == $y) {
                    $row .= $indicator;
                } else {
                    if ($attribute == 'gridDistances') {
                        $distance = $this->{$attribute}[$y][$x] ?? -1;
                        if ($distance === '#') {
                            $row .= '#';
                        } elseif (($this->grid[$y][$x] ?? -1) === self::DROID_STATUS_OXYGEN) {
                            $row .= 'O';
                        } elseif (-1 < $distance && $distance < 16) {
                            $row .= sprintf('%X', $distance % 16);
                        } elseif (is_numeric($distance)) {
                            $row .= ' ';
                        } else {
                            $row .= '#';
                        }
                    } else {
                        $row .= $this->{$attribute}[$y][$x] ?? self::DROID_STATUS_WALL == self::DROID_STATUS_WALL ? ' ' : '#';
                    }
                }
            }
            $image[$y] = $row;
        }
        krsort($image, SORT_NUMERIC);
        echo "\n\n".implode("\n", $image)."\n\n";
    }

    public function findOxygenDistance()
    {
        foreach ($this->grid as $y => $row) {
            foreach ($this->grid[$y] as $x => $value) {
                if ($value === self::DROID_STATUS_OXYGEN) {
                    return $this->gridDistances[$y][$x];
                }
            }
        }
        return -1;
    }

    public function findOxygenDuration()
    {
        $maxDistance = -1;
        foreach ($this->grid as $y => $row) {
            foreach ($this->grid[$y] as $x => $value) {
                $maxDistance = max($maxDistance, $this->gridDistances[$y][$x]);
            }
        }
        return $maxDistance;
    }
}