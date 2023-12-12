package day9

import "testing"

func TestOne(t *testing.T) {
	result := One(testInput())
	if "114" != result {
		t.Fatalf("failed to calculate sum of extrapolations: %v", result)
	}
}

func TestTwo(t *testing.T) {
	result := Two(testInput())
	if "2" != result {
		t.Fatalf("failed to calculate sum of extrapolations: %v", result)
	}
}

func testInput() string {
	return `0 3 6 9 12 15
1 3 6 10 15 21
10 13 16 21 30 45`
}
