package day5

import (
	"fmt"
	"log"
	"regexp"
	"strconv"
	"strings"
)

type MapRange struct {
	Min    int
	Max    int
	Offset int
}

type MapBlock struct {
	SourceName      string
	DestinationName string
	MapRanges       []MapRange
}

func (mb MapBlock) Map(input int) int {
	for _, mapRange := range mb.MapRanges {
		if input >= mapRange.Min && input <= mapRange.Max {
			return input + mapRange.Offset
		}
	}
	return input
}

func (mb MapBlock) MapRecursively(input int, mapBlocks map[string]MapBlock) int {
	mappedNumber := mb.Map(input)
	if _, ok := mapBlocks[mb.DestinationName]; !ok {
		return mappedNumber
	}
	return mapBlocks[mb.DestinationName].MapRecursively(mappedNumber, mapBlocks)
}

func One(input string) string {
	sections := strings.Split(input, "\n\n")
	seeds := parseSeeds(sections[0])
	mapBlocks := make(map[string]MapBlock)
	for _, mapBlockString := range sections[1:] {
		mapSource, mapBlock := parseMapBlock(mapBlockString)
		mapBlocks[mapSource] = mapBlock
	}
	var locations []int
	for _, seed := range seeds {
		locations = append(locations, mapBlocks["seed"].MapRecursively(seed, mapBlocks))
	}
	minimumDistance := 0
	for _, location := range locations {
		if minimumDistance == 0 || location < minimumDistance {
			minimumDistance = location
		}
	}

	return strconv.Itoa(minimumDistance)
}

func parseMapBlock(mapBlock string) (string, MapBlock) {
	lines := strings.Split(mapBlock, "\n")
	re := regexp.MustCompile(`(\w+)\-to\-(\w+)`)
	submatches := re.FindSubmatch([]byte(lines[0]))
	if len(submatches) != 3 {
		log.Fatalf("failed to parse map block: %v", lines[0])
	}
	sourceName := string(submatches[1])
	destinationName := string(submatches[2])
	var ranges []MapRange
	for _, line := range lines[1:] {
		ranges = append(ranges, parseRange(line))
	}
	return sourceName, MapBlock{
		SourceName:      sourceName,
		DestinationName: destinationName,
		MapRanges:       ranges,
	}
}

func parseRange(line string) MapRange {
	var destination int
	var source int
	var length int
	_, err := fmt.Sscanf(line, "%d %d %d", &destination, &source, &length)
	if err != nil {
		log.Fatalf("failed to parse range: %v", err)
	}
	return MapRange{
		Min:    source,
		Max:    source + length - 1,
		Offset: destination - source,
	}
}

func parseSeeds(line string) []int {
	splitLine := strings.Split(line, ":")
	return parseNumbers(strings.TrimSpace(splitLine[1]))
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
