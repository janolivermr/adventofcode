<?php

namespace AoC\Advent2019;

class Dec08
{
    /** @var string */
    protected string $input;

    /** @var int */
    protected int $width;

    /** @var int */
    protected int $height;

    /** @var array */
    protected array $layers = [];

    public function __construct($input, $width, $height)
    {
        $this->input = $input;
        $this->width = $width;
        $this->height = $height;
    }

    public function decodeToLayers()
    {
        $layerStrings = str_split($this->input, $this->width * $this->height);
        foreach ($layerStrings as $layerIndex => $layerString) {
            $this->layers[$layerIndex] = [];
            $rows = str_split($layerString, $this->width);
            foreach ($rows as $rowIndex => $row) {
                $this->layers[$layerIndex][$rowIndex] = array_map('intval', str_split($row));
            }
        }
    }

    public function getLayerCountOf(int $layerIndex, int $value)
    {
        $numberCount = 0;
        foreach ($this->layers[$layerIndex] as $row) {
            foreach ($row as $digit) {
                if (intval($digit) === $value) {
                    $numberCount++;
                }
            }
        }
        return $numberCount;
    }

    public function getLayerWithFewestZeroes(): int
    {
        $zeroesCount = [];
        foreach (array_keys($this->layers) as $layerIndex) {
            $zeroesCount[$layerIndex] = $this->getLayerCountOf($layerIndex, 0);
        }
        asort($zeroesCount);
        return array_keys($zeroesCount)[0];
    }

    public function calculateChecksum()
    {
        $lowestZeroes = $this->getLayerWithFewestZeroes();
        $onesCount = $this->getLayerCountOf($lowestZeroes, 1);
        $twosCount = $this->getLayerCountOf($lowestZeroes, 2);
        return $onesCount * $twosCount;
    }

    public function buildImage(): array
    {
        $image = [];
        for($x = 0; $x < $this->height; $x++) {
            $image[$x] = [];
            for($y = 0; $y < $this->width; $y++) {
                $image[$x][$y] = ' ';
                foreach ($this->layers as $layer) {
                    if ($layer[$x][$y] !== 2) {
                        $image[$x][$y] = $layer[$x][$y];
                        break;
                    }
                }
            }
        }
        return $image;
    }

    public function renderImage(): string
    {
        $imageData = $this->buildImage();
        $lines = [];
        foreach ($imageData as $line) {
            $lines[] = implode('', $line);
        }
        return implode("\n", $lines);
    }

    public function getLayers(): array
    {
        return $this->layers;
    }
}