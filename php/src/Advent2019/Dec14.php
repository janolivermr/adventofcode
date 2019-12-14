<?php

namespace AoC\Advent2019;

class Dec14
{
    protected array $reactions = [];
    protected array $availableElements = [];

    public function __construct($reactionRecipes, $oreAvailable = 0)
    {
        $this->availableElements['ORE'] = $oreAvailable;
        foreach ($reactionRecipes as $reactionRecipe) {
            list($inputString, $outputString) = explode('=>', $reactionRecipe);
            $inputs = array_reduce(explode(',', $inputString), function ($carry, $input) {
                list($q, $e) = explode(' ', trim($input));
                $carry[$e] = intval($q);
                return $carry;
            }, []);
            $outputs = array_reduce(explode(',', $outputString), function ($carry, $output) {
                list($q, $e) = explode(' ', trim($output));
                $carry[$e] = intval($q);
                return $carry;
            }, []);
            foreach ($outputs as $element => $quantity) {
                $this->reactions[$element] = [
                    'inputs' => $inputs,
                    'outputs' => $outputs,
                ];
                $this->availableElements[$element] = 0;
            }
        }
    }

    public function calculateOreForElement($element = 'FUEL', $quantity = 1)
    {
        if ($element === 'ORE') {
            return $quantity;
        }
        echo_dbg(sprintf("Making %sx %s. ", $quantity, $element));
        $oreCount = 0;
        $reaction = $this->reactions[$element];
        $reactionsRequired = ceil($quantity/$reaction['outputs'][$element]);
        echo_dbg(sprintf("Making %sx %s requires %s reactions.\n", $quantity, $element, $reactionsRequired));
        foreach ($reaction['inputs'] as $inElement => $inQuantity) {
            $quantityRequired = $reactionsRequired * $inQuantity;
            echo_dbg(sprintf("Need %sx %s, available already: %sx\n", $quantityRequired, $inElement, ($this->availableElements[$inElement] ?? 0)));
            $quantityFromStock = min($quantityRequired, $this->availableElements[$inElement] ?? 0);
            $this->availableElements[$inElement] -= $quantityFromStock;
            $quantityRequired -= $quantityFromStock;
            $oreCount += $this->calculateOreForElement($inElement, $quantityRequired);
        }
        foreach ($reaction['outputs'] as $outElement => $outQuantity) {
            $produced = $reactionsRequired * $outQuantity;
            $surplus = $produced - ($outElement === $element ? $quantity : 0);
            echo_dbg(sprintf("Produced %sx %s, surplus %sx\n", $produced, $outElement, $surplus));
            $this->availableElements[$outElement] = ($this->availableElements[$outElement] ?? 0) + $surplus;
        }
        return $oreCount;
    }

    public function produceMaxFuel($oreForOne)
    {
        $fuelProduced = 0;
        do {
            $minFuelPossible = max(floor($this->availableElements['ORE']/$oreForOne), 1);
            $this->calculateOreForElement('FUEL', $minFuelPossible);
            $fuelProduced += $minFuelPossible;
        } while ($this->availableElements['ORE'] > 0);
        return $fuelProduced - 1;
    }
}