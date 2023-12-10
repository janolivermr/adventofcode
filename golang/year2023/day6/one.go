package day6

import (
	"log"
	"math"
	"strconv"
	"strings"
)

type BoatRace struct {
	AvailableTime  int
	RecordDistance int
}

func (br BoatRace) WinningRange() (int, int) {
	p := float64(-br.AvailableTime)
	halfP := p / 2
	// Add a tiny offset to the distance to beat, allowing us to exclude exact integer matches that lead to a tie.
	q := float64(br.RecordDistance) + 10e-9
	underSquareRoot := (halfP * halfP) - q
	inFront := -halfP
	sqrtValue := math.Sqrt(math.Abs(underSquareRoot))
	minimum := inFront - sqrtValue
	maximum := inFront + sqrtValue
	return int(math.Ceil(minimum)), int(math.Floor(maximum))
}

func One(input string) string {
	lines := strings.Split(input, "\n")
	times := parseNumbers(lines[0])
	distances := parseNumbers(lines[1])
	var boatRaces []BoatRace
	for i := 0; i < len(times); i++ {
		boatRaces = append(boatRaces, BoatRace{
			AvailableTime:  times[i],
			RecordDistance: distances[i],
		})
	}
	recordBeatingCombinations := 1 // we can ignore 0 here, since it would be produced by a single impossible race
	for _, boatRace := range boatRaces {
		minimum, maximum := boatRace.WinningRange()
		recordBeatingCombinations *= maximum - minimum + 1
	}
	return strconv.Itoa(recordBeatingCombinations)
}

func parseNumbers(line string) []int {
	splitLine := strings.Split(line, ":")
	numbers := strings.Split(splitLine[1], " ")
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
