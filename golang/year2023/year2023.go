package year2023

import (
	"fmt"
	"github.com/janolivermr/adventofcode/golang/year2023/day1"
	"github.com/janolivermr/adventofcode/golang/year2023/day2"
	"github.com/janolivermr/adventofcode/golang/year2023/day3"
	"github.com/janolivermr/adventofcode/golang/year2023/day4"
	"github.com/janolivermr/adventofcode/golang/year2023/day5"
	"github.com/janolivermr/adventofcode/golang/year2023/day6"
	"github.com/janolivermr/adventofcode/golang/year2023/day7"
	"github.com/janolivermr/adventofcode/golang/year2023/day8"
	"github.com/janolivermr/adventofcode/golang/year2023/day9"
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
	fmt.Println(" ")
	fmt.Printf("Day 2, Part One: %v\n", day2.One(getFileContents("02")))
	fmt.Printf("Day 2, Part Two: %v\n", day2.Two(getFileContents("02")))
	fmt.Println(" ")
	fmt.Printf("Day 3, Part One: %v\n", day3.One(getFileContents("03")))
	fmt.Printf("Day 3, Part Two: %v\n", day3.Two(getFileContents("03")))
	fmt.Println(" ")
	fmt.Printf("Day 4, Part One: %v\n", day4.One(getFileContents("04")))
	fmt.Printf("Day 4, Part Two: %v\n", day4.Two(getFileContents("04")))
	fmt.Println(" ")
	fmt.Printf("Day 5, Part One: %v\n", day5.One(getFileContents("05")))
	fmt.Printf("Day 5, Part Two: %v\n", day5.Two(getFileContents("05")))
	fmt.Println(" ")
	fmt.Printf("Day 6, Part One: %v\n", day6.One(getFileContents("06")))
	fmt.Printf("Day 6, Part Two: %v\n", day6.Two(getFileContents("06")))
	fmt.Println(" ")
	fmt.Printf("Day 7, Part One: %v\n", day7.One(getFileContents("07")))
	fmt.Printf("Day 7, Part Two: %v\n", day7.Two(getFileContents("07")))
	fmt.Println(" ")
	fmt.Printf("Day 8, Part One: %v\n", day8.One(getFileContents("08")))
	fmt.Printf("Day 8, Part Two: %v\n", day8.Two(getFileContents("08")))
	fmt.Println(" ")
	fmt.Printf("Day 9, Part One: %v\n", day9.One(getFileContents("09")))
	fmt.Printf("Day 9, Part Two: %v\n", day9.Two(getFileContents("09")))
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
	return strings.TrimSpace(string(input))
}
