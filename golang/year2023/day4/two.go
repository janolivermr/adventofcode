package day4

import (
	"strconv"
	"strings"
)

func (s Scratchcard) TotalScratchcards(scratchcards map[int]*Scratchcard, cache map[int]int) int {
	if cachedScratchcardCount, ok := cache[s.ScratchcardNumber]; ok {
		return cachedScratchcardCount
	}
	scratchcardCount := 1
	for i := s.ScratchcardNumber + 1; i <= s.ScratchcardNumber+s.MatchesCount(); i++ {
		scratchcardCount += scratchcards[i].TotalScratchcards(scratchcards, cache)
	}
	cache[s.ScratchcardNumber] = scratchcardCount
	return scratchcardCount
}

func Two(input string) string {
	lines := strings.Split(input, "\n")
	scratchcards := make(map[int]*Scratchcard)
	for _, line := range lines {
		scratchcard := parseLine(line)
		scratchcards[scratchcard.ScratchcardNumber] = scratchcard
	}
	scratchcardValue := 0
	cache := make(map[int]int, len(scratchcards))
	for _, scratchcard := range scratchcards {
		scratchcardValue += scratchcard.TotalScratchcards(scratchcards, cache)
	}
	return strconv.Itoa(scratchcardValue)
}
