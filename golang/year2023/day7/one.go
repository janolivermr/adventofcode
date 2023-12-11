package day7

import (
	"log"
	"sort"
	"strconv"
	"strings"
)

type HandType uint8

const (
	FiveOfAKind  HandType = 6
	FourOfAKind  HandType = 5
	FullHouse    HandType = 4
	ThreeOfAKind HandType = 3
	TwoPairs     HandType = 2
	OnePair      HandType = 1
	HighCard     HandType = 0
)

type Hand struct {
	Type         HandType
	NumericValue int
	Bid          int
}

func (h Hand) ComparisonValue() int {
	// Highest card value is 0xFFFFF, so we multiply the type by 0x100000 to make sure it's the most significant digit
	return int(h.Type)*0x100000 + h.NumericValue
}

func One(input string) string {
	lines := strings.Split(input, "\n")
	hands := make([]Hand, len(lines))
	for i, line := range lines {
		hands[i] = parseHand(line)
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

func parseHand(line string) Hand {
	splitLine := strings.Split(line, " ")
	bid, err := strconv.Atoi(splitLine[1])
	if err != nil {
		log.Fatalf("failed to parse bid: %v", err)
	}
	cardString := splitLine[0]
	cardString = strings.ReplaceAll(cardString, "A", "E")
	cardString = strings.ReplaceAll(cardString, "K", "D")
	cardString = strings.ReplaceAll(cardString, "Q", "C")
	cardString = strings.ReplaceAll(cardString, "J", "B")
	cardString = strings.ReplaceAll(cardString, "T", "A")
	cardValue, err := strconv.ParseInt(cardString, 16, 64)
	if err != nil {
		log.Fatalf("failed to parse card value: %v", err)
	}
	return Hand{
		Type:         determineHandType([]byte(cardString)),
		NumericValue: int(cardValue),
		Bid:          bid,
	}
}

func determineHandType(cards []byte) HandType {
	iCards := make([]int, len(cards))
	for i, card := range cards {
		integerCard, err := strconv.ParseInt(string(card), 16, 64)
		if err != nil {
			log.Fatalf("failed to parse card value: %v", err)
		}
		iCards[i] = int(integerCard)
	}
	sort.SliceStable(iCards, func(i, j int) bool {
		return iCards[i] < iCards[j]
	})
	if iCards[0] == iCards[1] && iCards[1] == iCards[2] && iCards[2] == iCards[3] && iCards[3] == iCards[4] {
		return FiveOfAKind
	}
	if iCards[0] == iCards[1] && iCards[1] == iCards[2] && iCards[2] == iCards[3] || iCards[1] == iCards[2] && iCards[2] == iCards[3] && iCards[3] == iCards[4] {
		return FourOfAKind
	}
	if iCards[0] == iCards[1] && iCards[1] == iCards[2] && iCards[3] == iCards[4] || iCards[0] == iCards[1] && iCards[2] == iCards[3] && iCards[3] == iCards[4] {
		return FullHouse
	}
	if iCards[0] == iCards[1] && iCards[1] == iCards[2] || iCards[1] == iCards[2] && iCards[2] == iCards[3] || iCards[2] == iCards[3] && iCards[3] == iCards[4] {
		return ThreeOfAKind
	}
	if iCards[0] == iCards[1] && iCards[2] == iCards[3] || iCards[0] == iCards[1] && iCards[3] == iCards[4] || iCards[1] == iCards[2] && iCards[3] == iCards[4] {
		return TwoPairs
	}
	if iCards[0] == iCards[1] || iCards[1] == iCards[2] || iCards[2] == iCards[3] || iCards[3] == iCards[4] {
		return OnePair
	}
	return HighCard
}
