package day11

import (
	"math"
	"strconv"
	"strings"
)

type Galaxy struct {
	X  int
	Y  int
	Id int
}

func One(input string) string {
	lines := strings.Split(input, "\n")
	expandedLines := expandLinesHorizontally(expandLinesVertically(lines))
	galaxies := findGalaxies(expandedLines)
	distances := make(map[string]int)
	for _, galaxyOne := range galaxies {
		for _, galaxyTwo := range galaxies {
			if galaxyOne.Id != galaxyTwo.Id {
				pairIndex := calculatePairIndex(galaxyOne, galaxyTwo)
				if _, ok := distances[pairIndex]; !ok {
					distances[pairIndex] = taxiCabDistance(galaxyOne, galaxyTwo)
				}
			}
		}
	}
	sum := 0
	for _, distance := range distances {
		sum += distance
	}
	return strconv.Itoa(sum)
}

func expandLinesVertically(lines []string) []string {
	var expandedLines []string
	for _, line := range lines {
		expandedLines = append(expandedLines, line)
		allDots := true
		for _, char := range line {
			if char != '.' {
				allDots = false
				break
			}
		}
		if allDots {
			expandedLines = append(expandedLines, line)
		}
	}
	return expandedLines
}

func expandLinesHorizontally(lines []string) []string {
	expandedLines := make([]string, len(lines))
	for col := 0; col < len(lines[0]); col++ {
		allDots := true
		for row := 0; row < len(lines); row++ {
			expandedLines[row] += string(lines[row][col])
			if lines[row][col] != '.' {
				allDots = false
			}
		}
		if allDots {
			for row := 0; row < len(lines); row++ {
				expandedLines[row] += "."
			}
		}
	}
	return expandedLines
}

func findGalaxies(lines []string) []Galaxy {
	var galaxies []Galaxy
	for row := 0; row < len(lines); row++ {
		for col := 0; col < len(lines[0]); col++ {
			if lines[row][col] == '#' {
				galaxies = append(galaxies, Galaxy{X: col, Y: row, Id: len(galaxies) + 1})
			}
		}
	}
	return galaxies
}

func calculatePairIndex(a Galaxy, b Galaxy) string {
	if a.Id < b.Id {
		return strconv.Itoa(a.Id) + "_" + strconv.Itoa(b.Id)
	}
	return strconv.Itoa(b.Id) + "_" + strconv.Itoa(a.Id)
}

func taxiCabDistance(a Galaxy, b Galaxy) int {
	return int(math.Abs(float64(a.X-b.X)) + math.Abs(float64(a.Y-b.Y)))
}
