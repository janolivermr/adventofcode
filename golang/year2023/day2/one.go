package day2

import (
	"fmt"
	"log"
	"strconv"
	"strings"
)

type GameSubset struct {
	Red   int
	Green int
	Blue  int
}

func One(input string) string {
	lines := strings.Split(input, "\n")
	bagContents := GameSubset{Red: 12, Green: 13, Blue: 14}
	idSum := 0
	for _, line := range lines {
		game, subsets := parseLine(line)
		validSubsetCount := 0
		for _, gameSubset := range subsets {
			if gameSubset.Red <= bagContents.Red && gameSubset.Green <= bagContents.Green && gameSubset.Blue <= bagContents.Blue {
				validSubsetCount++
			}
		}
		if validSubsetCount == len(subsets) {
			idSum += game
		}
	}
	return strconv.Itoa(idSum)
}

func parseLine(line string) (int, []*GameSubset) {
	splitLine := strings.Split(line, ":")
	gameSubsetStrings := strings.Split(strings.TrimSpace(splitLine[1]), ";")
	gameSubsets := make([]*GameSubset, len(gameSubsetStrings))
	for i, gameSubsetString := range gameSubsetStrings {
		gameSubsets[i] = parseGameSubset(gameSubsetString)
	}
	return parseGameNumber(splitLine[0]), gameSubsets
}

func parseGameNumber(line string) int {
	var gameNumber int
	_, err := fmt.Sscanf(line, "Game %d", &gameNumber)
	if err != nil {
		log.Fatalf("failed to parse game number: %v", err)
	}
	return gameNumber
}

func parseGameSubset(gameSubsetString string) *GameSubset {
	cubeCounts := strings.Split(gameSubsetString, ",")
	red := 0
	green := 0
	blue := 0
	for _, cubeCount := range cubeCounts {
		var color string
		var value int
		_, err := fmt.Sscanf(cubeCount, "%d %s", &value, &color)
		if err != nil {
			log.Fatalf("failed to parse cube count: %v", err)
		}
		switch color {
		case "red":
			red += value
		case "green":
			green += value
		case "blue":
			blue += value
		}
	}
	return &GameSubset{Red: red, Green: green, Blue: blue}
}
