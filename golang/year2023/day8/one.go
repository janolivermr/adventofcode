package day8

import (
	"regexp"
	"strconv"
	"strings"
)

type Node struct {
	Value string
	Left  int
	Right int
}

func One(input string) string {
	sections := strings.Split(input, "\n\n")
	instructions := []byte(strings.TrimSpace(sections[0]))
	networkLines := strings.Split(strings.TrimSpace(sections[1]), "\n")
	network := make(map[int]Node)
	for _, networkLine := range networkLines {
		re := regexp.MustCompile(`(\w+)\s*=\s*\((\w+)\s*,\s*(\w+)\)`)
		matches := re.FindStringSubmatch(networkLine)
		network[intIndex(matches[1])] = Node{
			Value: matches[1],
			Left:  intIndex(matches[2]),
			Right: intIndex(matches[3]),
		}
	}
	steps := 0
	currentNode := network[intIndex("AAA")]
	for i := 0; currentNode.Value != "ZZZ"; i = (i + 1) % len(instructions) {
		if instructions[i] == 'L' {
			currentNode = network[currentNode.Left]
		} else if instructions[i] == 'R' {
			currentNode = network[currentNode.Right]
		}
		steps++
	}
	return strconv.Itoa(steps)
}

func intIndex(s string) int {
	chars := []rune(s)
	return int(chars[0]*1_00_00 + chars[1]*1_00 + chars[2])
}
