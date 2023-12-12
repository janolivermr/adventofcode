package day9

import (
	"math"
	"strconv"
	"strings"
)

func Two(input string) string {
	lines := strings.Split(input, "\n")
	sum := 0
	for _, line := range lines {
		points := paresPoints(line)
		xValue := -1.0
		yValue := calculateValue(points, xValue)
		sum += int(math.Round(yValue))
	}
	return strconv.Itoa(sum)
}
