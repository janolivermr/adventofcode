package year2023

import (
	"fmt"
	"github.com/janolivermr/adventofcode/golang/year2023/day1"
	"log"
	"os"
	"path/filepath"
	"strings"
)

func TwentyTwentyThree() {
	fmt.Println("Advent of Code 2023")
	fmt.Println("===================")
	fmt.Printf("Day 1, Part One: %v\n", day1.One(getFileContents("01")))
	fmt.Printf("Day 1, Part Two: %v\n", day1.Two(getFileContents("01")))
	fmt.Println("===================")
}

func getFileContents(day string) string {
	path, err := os.Getwd()
	if err != nil {
		log.Fatalf("failed to get working directory: %v", err)
	}
	input, err := os.ReadFile(filepath.Join(strings.ReplaceAll(path, "golang", "input"), "Advent2023", "Dec"+day+".txt"))
	if err != nil {
		log.Fatalf("failed to read input: %v", err)
	}
	return string(input)
}
