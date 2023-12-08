package day1

import (
	"testing"
)

func TestOne(t *testing.T) {
	result := One("1abc2\npqr3stu8vwx\na1b2c3d4e5f\ntreb7uchet")
	if "142" != result {
		t.Fatalf("failed to calibrate: %v", result)
	}
}

func TestTwo(t *testing.T) {
	result := Two("two1nine\neightwothree\nabcone2threexyz\nxtwone3four\n4nineeightseven2\nzoneight234\n7pqrstsixteen")
	if "281" != result {
		t.Fatalf("failed to calibrate: %v", result)
	}
}
