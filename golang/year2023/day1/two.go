package day1

import (
	"log"
	"strconv"
	"strings"
)

func Two(input string) string {
	lines := strings.Split(input, "\n")
	calibrationValues := make([]int, len(lines))
	for i, line := range lines {
		// First idea was to convert digits to their string represenstation, but cases like `tw1` would be a problem.
		// It would translate to `twone`, the original would find `1` as the first digit, but now finds `two`.
		tensIndex := -1
		tensDigit := ""
		onesIndex := -1
		onesDigit := ""
		for _, search := range []string{"0", "one", "1", "two", "2", "three", "3", "four", "4", "five", "5", "six", "6", "seven", "7", "eight", "8", "nine", "9"} {
			firstIndex := strings.Index(line, search)
			if firstIndex != -1 && (tensIndex == -1 || firstIndex < tensIndex) {
				tensIndex = firstIndex
				tensDigit = textToDigit(search)
			}
			lastIndex := strings.LastIndex(line, search)
			if lastIndex != -1 && (onesIndex == -1 || lastIndex > onesIndex) {
				onesIndex = lastIndex
				onesDigit = textToDigit(search)
			}
		}
		tensPosition, err := strconv.Atoi(tensDigit)
		onesPosition, err := strconv.Atoi(onesDigit)
		if err != nil {
			log.Fatalf("failed to convert string to int: %v", err)
		}
		calibrationValues[i] = 10*tensPosition + onesPosition
	}
	sum := 0
	for _, value := range calibrationValues {
		sum += value
	}
	return strconv.Itoa(sum)
}

func textToDigit(text string) string {
	switch text {
	case "one", "1":
		return "1"
	case "two", "2":
		return "2"
	case "three", "3":
		return "3"
	case "four", "4":
		return "4"
	case "five", "5":
		return "5"
	case "six", "6":
		return "6"
	case "seven", "7":
		return "7"
	case "eight", "8":
		return "8"
	case "nine", "9":
		return "9"
	}
	return text
}
