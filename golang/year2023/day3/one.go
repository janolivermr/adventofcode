package day3

import (
	"log"
	"strconv"
	"strings"
)

type PartNumber struct {
	NumberString string
	Row          int
	Column       int
}

func (pn PartNumber) BoundingBox() (int, int, int, int) {
	return pn.Row - 1, pn.Column - 1, pn.Row + 1, pn.Column + len(pn.NumberString)
}

func One(input string) string {
	lines := strings.Split(input, "\n")
	var potentialPartNumbers []PartNumber
	symbols := make(map[string]string)
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
					symbols[keyFromCoords(y, x)] = string(char)
				}
			}
		}
		if nextPartNumber.NumberString != "" {
			potentialPartNumbers = append(potentialPartNumbers, nextPartNumber)
		}
	}
	var actualPartNumbers []PartNumber

	for _, partNumber := range potentialPartNumbers {
		symbol := isValidPartNumber(partNumber, symbols)
		if symbol != "" {
			actualPartNumbers = append(actualPartNumbers, partNumber)
		}
	}
	partNumberSum := 0
	for _, partNumber := range actualPartNumbers {
		partNumberValue, err := strconv.Atoi(partNumber.NumberString)
		if err != nil {
			log.Fatalf("failed to convert string to int: %v", err)
		}
		partNumberSum += partNumberValue
	}
	return strconv.Itoa(partNumberSum)
}

func isValidPartNumber(partNumber PartNumber, symbols map[string]string) string {
	rowStart, columnStart, rowEnd, columnEnd := partNumber.BoundingBox()
	for y := rowStart; y <= rowEnd; y++ {
		for x := columnStart; x <= columnEnd; x++ {
			symbol, ok := symbols[keyFromCoords(y, x)]
			if ok {
				return symbol
			}
		}
	}
	return ""
}

func keyFromCoords(y int, x int) string {
	return strconv.Itoa(y) + "_" + strconv.Itoa(x)
}
