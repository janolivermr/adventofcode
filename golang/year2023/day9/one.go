package day9

import (
	"log"
	"math"
	"strconv"
	"strings"
)

type Point struct {
	X float64
	Y float64
}

func One(input string) string {
	lines := strings.Split(input, "\n")
	sum := 0
	for _, line := range lines {
		points := paresPoints(line)
		xValue := float64(len(points))
		yValue := calculateValue(points, xValue)
		sum += int(math.Round(yValue))
	}
	return strconv.Itoa(sum)
}

func paresPoints(line string) []Point {
	numbers := strings.Split(line, " ")
	points := make([]Point, len(numbers))
	for i, number := range numbers {
		yInt, err := strconv.Atoi(number)
		if err != nil {
			log.Fatalf("failed to parse number: %v", err)
		}
		points[i] = Point{
			X: float64(i),
			Y: float64(yInt),
		}
	}
	return points
}

func calculateValue(points []Point, xValue float64) float64 {
	coefficients := newtonCoefficients(points)
	result := 0.0
	for i := 0; i < len(coefficients); i++ {
		factor := 1.0
		for j := 0; j < i; j++ {
			factor *= xValue - points[j].X
		}
		result += coefficients[i] * factor
	}
	return result
}

func newtonCoefficients(points []Point) []float64 {
	var result []float64
	for i := 0; i < len(points); i++ {
		result = append(result, points[i].Y)
	}
	for i := 1; i < len(points); i++ {
		for j := len(points) - 1; j >= i; j-- {
			result[j] = (result[j] - result[j-1]) / (points[j].X - points[j-i].X)
		}
	}
	return result
}

//func newtonPolynomial(x []float64, y []float64, n int) []float64 {
//	var result []float64
//	for i := 0; i < n; i++ {
//		result = append(result, y[i])
//	}
//	for i := 1; i < n; i++ {
//		for j := n - 1; j >= i; j-- {
//			result[j] = (result[j] - result[j-1]) / (x[j] - x[j-i])
//		}
//	}
//	return result
//}
