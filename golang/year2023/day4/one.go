package day4

import (
	"fmt"
	"log"
	"math"
	"strconv"
	"strings"
)

type Scratchcard struct {
	ScratchcardNumber int
	WinningNumbers    []int
	PrintedNumbers    []int
}

func (s Scratchcard) Value() int {
	matches := s.MatchesCount()
	if matches == 0 {
		return 0
	}
	return int(math.Pow(2, float64(matches-1)))
}

func (s Scratchcard) MatchesCount() int {
	winningNumersMap := make(map[int]bool)
	for _, winningNumber := range s.WinningNumbers {
		winningNumersMap[winningNumber] = true
	}
	var matches []int
	for _, printedNumber := range s.PrintedNumbers {
		if _, ok := winningNumersMap[printedNumber]; ok {
			matches = append(matches, printedNumber)
		}
	}
	return len(matches)
}

func One(input string) string {
	lines := strings.Split(input, "\n")
	scratchcardValue := 0
	for _, line := range lines {
		scratchcard := parseLine(line)
		scratchcardValue += scratchcard.Value()
	}
	return strconv.Itoa(scratchcardValue)
}

func parseLine(line string) *Scratchcard {
	splitLine := strings.Split(line, ":")
	splitNumbers := strings.Split(splitLine[1], "|")
	return &Scratchcard{
		ScratchcardNumber: parseScratchcardNumber(splitLine[0]),
		WinningNumbers:    parseNumbers(strings.TrimSpace(splitNumbers[0])),
		PrintedNumbers:    parseNumbers(strings.TrimSpace(splitNumbers[1])),
	}
}

func parseNumbers(numbersString string) []int {

	numbers := strings.Split(numbersString, " ")
	var parsedNumbers []int
	for _, number := range numbers {
		if number == "" || number == " " {
			continue
		}
		parsedNumber, err := strconv.Atoi(number)
		if err != nil {
			log.Fatalf("failed to parse number: %v", err)
		}
		parsedNumbers = append(parsedNumbers, parsedNumber)
	}
	return parsedNumbers
}

func parseScratchcardNumber(line string) int {
	var scratchcardNumber int
	_, err := fmt.Sscanf(line, "Card %d", &scratchcardNumber)
	if err != nil {
		log.Fatalf("failed to parse scratchcard number: %v", err)
	}
	return scratchcardNumber
}
