package day11

import (
	"math"
	"strconv"
	"strings"
)

func (g Galaxy) expandedX(emptyColumns []int, factor int) int {
	x := g.X
	for _, emptyColumn := range emptyColumns {
		if emptyColumn < g.X {
			x += factor - 1
		}
	}
	return x
}

func (g Galaxy) expandedY(emptyLines []int, factor int) int {
	y := g.Y
	for _, emptyLine := range emptyLines {
		if emptyLine < g.Y {
			y += factor - 1
		}
	}
	return y
}

func Two(input string, factor int) string {
	lines := strings.Split(input, "\n")
	emptyLines := findEmptyLines(lines)
	emptyColumns := findEmptyColumns(lines)
	galaxies := findGalaxies(lines)
	distances := make(map[string]int)
	for _, galaxyOne := range galaxies {
		for _, galaxyTwo := range galaxies {
			if galaxyOne.Id != galaxyTwo.Id {
				pairIndex := calculatePairIndex(galaxyOne, galaxyTwo)
				if _, ok := distances[pairIndex]; !ok {
					distances[pairIndex] = expandedTaxiCabDistance(galaxyOne, galaxyTwo, emptyColumns, emptyLines, factor)
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

func findEmptyLines(lines []string) []int {
	var emptyLines []int
	for i, line := range lines {
		allDots := true
		for _, char := range line {
			if char != '.' {
				allDots = false
				break
			}
		}
		if allDots {
			emptyLines = append(emptyLines, i)
		}
	}
	return emptyLines
}

func findEmptyColumns(lines []string) []int {
	var emptyColumns []int
	for col := 0; col < len(lines[0]); col++ {
		allDots := true
		for row := 0; row < len(lines); row++ {
			if lines[row][col] != '.' {
				allDots = false
			}
		}
		if allDots {
			emptyColumns = append(emptyColumns, col)
		}
	}
	return emptyColumns
}

func expandedTaxiCabDistance(a Galaxy, b Galaxy, emptyColumns []int, emptyLines []int, factor int) int {
	return int(math.Abs(float64(a.expandedX(emptyColumns, factor)-b.expandedX(emptyColumns, factor))) + math.Abs(float64(a.expandedY(emptyLines, factor)-b.expandedY(emptyLines, factor))))
}
