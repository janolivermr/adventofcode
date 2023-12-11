package day8

import (
	"regexp"
	"strconv"
	"strings"
)

func (n Node) isEndingNode() bool {
	return ([]byte(n.Value))[2] == 'Z'
}

func Two(input string) string {
	sections := strings.Split(input, "\n\n")
	instructions := []byte(strings.TrimSpace(sections[0]))
	networkLines := strings.Split(strings.TrimSpace(sections[1]), "\n")
	network := make(map[int]Node)
	currentNodes := make(map[int]Node)
	for _, networkLine := range networkLines {
		re := regexp.MustCompile(`(\w+)\s*=\s*\((\w+)\s*,\s*(\w+)\)`)
		matches := re.FindStringSubmatch(networkLine)
		node := Node{
			Value: matches[1],
			Left:  intIndex(matches[2]),
			Right: intIndex(matches[3]),
		}
		network[intIndex(matches[1])] = node
		if ([]byte(matches[1]))[2] == 'A' {
			currentNodes[intIndex(matches[1])] = node
		}
	}
	var minimumStepList []int
	for _, currentNode := range currentNodes {
		steps := 0
		for i := 0; !(currentNode.isEndingNode() && steps%len(instructions) == 0); i = (i + 1) % len(instructions) {
			if instructions[i] == 'L' {
				currentNode = network[currentNode.Left]
			} else if instructions[i] == 'R' {
				currentNode = network[currentNode.Right]
			}
			steps++
		}
		minimumStepList = append(minimumStepList, steps)
	}
	return strconv.Itoa(leastCommonMultiple(minimumStepList...))
}

func greatestCommonDivisor(a, b int) int {
	if b == 0 {
		return a
	}
	return greatestCommonDivisor(b, a%b)
}

func leastCommonMultiple(integers ...int) int {
	result := integers[0] * integers[1] / greatestCommonDivisor(integers[0], integers[1])

	for i := 2; i < len(integers); i++ {
		result = leastCommonMultiple(result, integers[i])
	}

	return result
}
