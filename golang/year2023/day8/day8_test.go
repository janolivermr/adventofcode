package day8

import "testing"

func TestOne(t *testing.T) {
	t.Run("input original", func(t *testing.T) {
		result := One(testInput())
		if "2" != result {
			t.Fatalf("failed to calculate steps to ZZZ: %v", result)
		}
	})
	t.Run("input alternative", func(t *testing.T) {
		result := One(testInputAlternative())
		if "6" != result {
			t.Fatalf("failed to calculate steps to ZZZ: %v", result)
		}
	})
}

func TestTwo(t *testing.T) {
	t.Run("input simultaneous", func(t *testing.T) {
		result := Two(testInputSimultaneous())
		if "6" != result {
			t.Fatalf("failed to calculate steps to ZZZ: %v", result)
		}
	})
}

func testInput() string {
	return `RL

AAA = (BBB, CCC)
BBB = (DDD, EEE)
CCC = (ZZZ, GGG)
DDD = (DDD, DDD)
EEE = (EEE, EEE)
GGG = (GGG, GGG)
ZZZ = (ZZZ, ZZZ)`
}

func testInputAlternative() string {
	return `LLR

AAA = (BBB, BBB)
BBB = (AAA, ZZZ)
ZZZ = (ZZZ, ZZZ)`
}

func testInputSimultaneous() string {
	return `LR

11A = (11B, XXX)
11B = (XXX, 11Z)
11Z = (11B, XXX)
22A = (22B, XXX)
22B = (22C, 22C)
22C = (22Z, 22Z)
22Z = (22B, 22B)
XXX = (XXX, XXX)`
}
