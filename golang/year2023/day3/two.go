package day3

import (
	"log"
	"strconv"
	"strings"
)

type Part struct {
	Symbol      string
	PartNumbers []PartNumber
}

func Two(input string) string {
	lines := strings.Split(input, "\n")
	var potentialPartNumbers []PartNumber
	symbols := make(map[string]Part)
	for y, line := range lines {
		nextPartNumber := PartNumber{NumberString: "", Row: y, Column: -1}
		for x, char := range line {
			// check if char is a number between ASCII 0-9
			if char >= 0x30 && char <= 0x39 {
				if nextPartNumber.Column == -1 {
					nextPartNumber.Column = x
				}
				nextPartNumber.NumberString += string(char)
			} else {
				if nextPartNumber.NumberString != "" {
					potentialPartNumbers = append(potentialPartNumbers, nextPartNumber)
					nextPartNumber = PartNumber{NumberString: "", Row: y, Column: -1}
				}
				// check if char is a symbol
				if char != 0x2E {
					symbols[keyFromCoords(y, x)] = Part{Symbol: string(char), PartNumbers: []PartNumber{}}
				}
			}
		}
		if nextPartNumber.NumberString != "" {
			potentialPartNumbers = append(potentialPartNumbers, nextPartNumber)
		}
	}

	for _, partNumber := range potentialPartNumbers {
		assignToSymbol(partNumber, symbols)
	}

	gearRatioSum := 0
	for _, symbol := range symbols {
		if len(symbol.PartNumbers) == 2 && symbol.Symbol == "*" {
			gearOneValue, err := strconv.Atoi(symbol.PartNumbers[0].NumberString)
			gearTwoValue, err := strconv.Atoi(symbol.PartNumbers[1].NumberString)
			if err != nil {
				log.Fatalf("failed to convert string to int: %v", err)
			}
			gearRatioSum += gearOneValue * gearTwoValue
		}
	}
	return strconv.Itoa(gearRatioSum)
}

func assignToSymbol(partNumber PartNumber, symbols map[string]Part) bool {
	rowStart, columnStart, rowEnd, columnEnd := partNumber.BoundingBox()
	for y := rowStart; y <= rowEnd; y++ {
		for x := columnStart; x <= columnEnd; x++ {
			symbol, ok := symbols[keyFromCoords(y, x)]
			if ok {
				symbol.PartNumbers = append(symbols[keyFromCoords(y, x)].PartNumbers, partNumber)
				symbols[keyFromCoords(y, x)] = symbol
				return true
			}
		}
	}
	return false
}
