package day7

import (
	"log"
	"sort"
	"strconv"
	"strings"
)

func Two(input string) string {
	lines := strings.Split(input, "\n")
	hands := make([]Hand, len(lines))
	for i, line := range lines {
		hands[i] = parseHandWithJokers(line)
	}
	sort.SliceStable(hands, func(i, j int) bool {
		return hands[i].ComparisonValue() < hands[j].ComparisonValue()
	})
	totalWinnings := 0
	for i := 0; i < len(hands); i++ {
		totalWinnings += hands[i].Bid * (i + 1)
	}
	return strconv.Itoa(totalWinnings)
}

func parseHandWithJokers(line string) Hand {
	splitLine := strings.Split(line, " ")
	bid, err := strconv.Atoi(splitLine[1])
	if err != nil {
		log.Fatalf("failed to parse bid: %v", err)
	}
	cardString := splitLine[0]
	cardString = strings.ReplaceAll(cardString, "A", "E")
	cardString = strings.ReplaceAll(cardString, "K", "D")
	cardString = strings.ReplaceAll(cardString, "Q", "C")
	cardString = strings.ReplaceAll(cardString, "J", "1")
	cardString = strings.ReplaceAll(cardString, "T", "A")
	cardValue, err := strconv.ParseInt(cardString, 16, 64)
	if err != nil {
		log.Fatalf("failed to parse card value: %v", err)
	}
	jokerCount := strings.Count(splitLine[0], "J")
	handType := determineHandType([]byte(cardString))
	if handType == FourOfAKind && (jokerCount == 1 || jokerCount == 4) {
		handType = FiveOfAKind
	} else if handType == FullHouse && (jokerCount == 2 || jokerCount == 3) {
		handType = FiveOfAKind
	} else if handType == ThreeOfAKind && (jokerCount == 1 || jokerCount == 3) {
		handType = FourOfAKind
	} else if handType == TwoPairs && jokerCount == 1 {
		handType = FullHouse
	} else if handType == TwoPairs && jokerCount == 2 {
		handType = FourOfAKind
	} else if handType == OnePair && (jokerCount == 1 || jokerCount == 2) {
		handType = ThreeOfAKind
	} else if handType == HighCard && jokerCount == 1 {
		handType = OnePair
	}
	return Hand{
		Type:         handType,
		NumericValue: int(cardValue),
		Bid:          bid,
	}
}
