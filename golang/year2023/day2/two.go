package day2

import (
	"strconv"
	"strings"
)

func Two(input string) string {
	lines := strings.Split(input, "\n")
	powerSum := 0
	for _, line := range lines {
		_, subsets := parseLine(line)
		minimumBagContents := GameSubset{Red: 0, Green: 0, Blue: 0}
		for _, gameSubset := range subsets {
			if gameSubset.Red > minimumBagContents.Red {
				minimumBagContents.Red = gameSubset.Red
			}
			if gameSubset.Green > minimumBagContents.Green {
				minimumBagContents.Green = gameSubset.Green
			}
			if gameSubset.Blue > minimumBagContents.Blue {
				minimumBagContents.Blue = gameSubset.Blue
			}
		}
		powerSum += minimumBagContents.Red * minimumBagContents.Green * minimumBagContents.Blue
	}
	return strconv.Itoa(powerSum)
}
