package day7

import "testing"

func TestOne(t *testing.T) {
	result := One(testInput())
	if "6440" != result {
		t.Fatalf("failed to calculate total winnings: %v", result)
	}
}

func TestTwo(t *testing.T) {
	result := Two(testInput())
	if "5905" != result {
		t.Fatalf("failed to calculate total winnings: %v", result)
	}
}

func testInput() string {
	return `32T3K 765
T55J5 684
KK677 28
KTJJT 220
QQQJA 483`
}
