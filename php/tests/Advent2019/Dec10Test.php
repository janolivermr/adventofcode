<?php

namespace Tests\Advent2019;

use AoC\Advent2019\Dec10;
use Tests\TestCaseWithInput;

class Dec10Test extends TestCaseWithInput
{
    /**
     * @dataProvider partOneExamplesProvider
     */
    public function testPartOneExamples($input, $maxAsteroids)
    {
        $dec10 = new Dec10($input);
        $this->assertEquals($maxAsteroids, $dec10->maxAsteroidsVisible());
    }

    /**
     * @dataProvider partTwoExamplesProvider
     */
    public function testPartTwoExamples($input, $n, $expectedCoords)
    {
        $dec10 = new Dec10($input);
        $nthShot = $dec10->getNthShotAsteroidCoords($n);
        $this->assertEquals($expectedCoords, $nthShot);
    }

    public function runPartOne()
    {
        $inputs = array_map(function ($row) {
            return $row[0];
        }, iterator_to_array($this->getInput()));
        $dec10 = new Dec10($inputs);
        return $dec10->maxAsteroidsVisible();
    }

    public function runPartTwo()
    {
        $inputs = array_map(function ($row) {
            return $row[0];
        }, iterator_to_array($this->getInput()));
        $dec10 = new Dec10($inputs);
        $nthShot = $dec10->getNthShotAsteroidCoords(200);
        return 100 * $nthShot[0] + $nthShot[1];
    }

    public function partOneExamplesProvider()
    {
        return [
            [[
                '.#..#',
                '.....',
                '#####',
                '....#',
                '...##',
            ], 8],
            [[
                '......#.#.',
                '#..#.#....',
                '..#######.',
                '.#.#.###..',
                '.#..#.....',
                '..#....#.#',
                '#..#....#.',
                '.##.#..###',
                '##...#..#.',
                '.#....####',
            ], 33]
        ];
    }

    public function partTwoExamplesProvider()
    {
        return [
            [[
                '.#..##.###...#######',
                '##.############..##.',
                '.#.######.########.#',
                '.###.#######.####.#.',
                '#####.##.#.##.###.##',
                '..#####..#.#########',
                '####################',
                '#.####....###.#.#.##',
                '##.#################',
                '#####.##.###..####..',
                '..######..##.#######',
                '####.##.####...##..#',
                '.#####..#.######.###',
                '##...#.##########...',
                '#.##########.#######',
                '.####.#.###.###.#.##',
                '....##.##.###..#####',
                '.#.#.###########.###',
                '#.#.#.#####.####.###',
                '###.##.####.##.#..##',
            ], 200, [8, 2]]
        ];
    }
}