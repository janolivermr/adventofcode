package day11

import (
	"strings"
	"testing"
)

func TestOne(t *testing.T) {
	result := One(testInput())
	if "374" != result {
		t.Fatalf("failed to calculate sum of shortest galaxy distances: %v", result)
	}
}

func TestTwo(t *testing.T) {
	t.Run("factor 2", func(t *testing.T) {
		result := Two(testInput(), 2)
		if "374" != result {
			t.Fatalf("failed to calculate sum of shortest galaxy distances: %v", result)
		}
	})
	t.Run("factor 10", func(t *testing.T) {
		result := Two(testInput(), 10)
		if "1030" != result {
			t.Fatalf("failed to calculate sum of shortest galaxy distances: %v", result)
		}
	})
	t.Run("factor 100", func(t *testing.T) {
		result := Two(testInput(), 100)
		if "8410" != result {
			t.Fatalf("failed to calculate sum of shortest galaxy distances: %v", result)
		}
	})
}

func TestExpandLines(t *testing.T) {
	input := testInput()
	lines := strings.Split(input, "\n")
	expandedLines := expandLinesHorizontally(expandLinesVertically(lines))
	if expandedLinesOutput() != strings.Join(expandedLines, "\n") {
		t.Fatalf("failed to expand lines: %v", expandedLines)
	}
}

func testInput() string {
	return `...#......
.......#..
#.........
..........
......#...
.#........
.........#
..........
.......#..
#...#.....`
}

func expandedLinesOutput() string {
	return `....#........
.........#...
#............
.............
.............
........#....
.#...........
............#
.............
.............
.........#...
#....#.......`
}
