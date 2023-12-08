package day1

import (
	"log"
	"regexp"
	"strconv"
	"strings"
)

func One(input string) string {
	lines := strings.Split(input, "\n")
	calibrationValues := make([]int, len(lines))
	for i, line := range lines {
		re := regexp.MustCompile(`\D`)
		digitsOnly := re.ReplaceAll([]byte(line), []byte(""))
		tensPosition, err := strconv.Atoi(string(digitsOnly[0]))
		onesPosition, err := strconv.Atoi(string(digitsOnly[len(digitsOnly)-1]))
		if err != nil {
			log.Fatalf("failed to convert string to int: %v", err)
		}
		calibrationValues[i] = 10*tensPosition + onesPosition
	}
	sum := 0
	for _, value := range calibrationValues {
		sum += value
	}
	return strconv.Itoa(sum)
}
