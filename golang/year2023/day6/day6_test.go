package day6

import "testing"

func TestOne(t *testing.T) {
	result := One(testInput())
	if "288" != result {
		t.Fatalf("failed to calculate margin of error: %v", result)
	}
}

func TestTwo(t *testing.T) {
	result := Two(testInput())
	if "71503" != result {
		t.Fatalf("failed to calculate nearest location: %v", result)
	}
}

func testInput() string {
	return `Time:      7  15   30
Distance:  9  40  200`
}
