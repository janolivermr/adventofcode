package day3

import "testing"

func TestOne(t *testing.T) {
	result := One(testInput())
	if "4361" != result {
		t.Fatalf("failed to calculate part number sum: %v", result)
	}
}

func TestTwo(t *testing.T) {
	result := Two(testInput())
	if "467835" != result {
		t.Fatalf("failed to calculate cube power sum: %v", result)
	}
}

func testInput() string {
	return `467..114..
...*......
..35..633.
......#...
617*......
.....+.58.
..592.....
......755.
...$.*....
.664.598..`
}
