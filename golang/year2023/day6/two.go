package day6

import (
	"log"
	"strconv"
	"strings"
)

func Two(input string) string {
	lines := strings.Split(input, "\n")
	time := parseNumber(lines[0])
	distance := parseNumber(lines[1])
	boatRace := BoatRace{
		AvailableTime:  time,
		RecordDistance: distance,
	}
	minimum, maximum := boatRace.WinningRange()
	recordBeatingCombinations := maximum - minimum + 1
	return strconv.Itoa(recordBeatingCombinations)
}

func parseNumber(line string) int {
	splitLine := strings.Split(line, ":")
	numbers := strings.Split(splitLine[1], " ")
	number, err := strconv.Atoi(strings.Join(numbers, ""))
	if err != nil {
		log.Fatalf("failed to parse number: %v", err)
	}
	return number
}
