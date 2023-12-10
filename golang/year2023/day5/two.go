package day5

import (
	"sort"
	"strconv"
	"strings"
)

type DataRange struct {
	Min int
	Max int
}

func (mb MapBlock) ApplyMapToRanges(dataRanges []DataRange) []DataRange {
	sort.SliceStable(dataRanges, func(i, j int) bool {
		return dataRanges[i].Min < dataRanges[j].Min
	})
	sort.SliceStable(mb.MapRanges, func(i, j int) bool {
		return mb.MapRanges[i].Min < mb.MapRanges[j].Min
	})
	var splitDataRanges []DataRange
nextDataRange:
	for _, dataRange := range dataRanges {
		for _, mapRange := range mb.MapRanges {
			if dataRange.IsOutsideMapRange(mapRange) {
				continue
			}
			if dataRange.IsInsideMapRange(mapRange) {
				splitDataRanges = append(splitDataRanges, DataRange{
					Min: dataRange.Min + mapRange.Offset,
					Max: dataRange.Max + mapRange.Offset,
				})
				continue nextDataRange
			}
			if dataRange.IsOverlappingMapRangeStart(mapRange) {
				splitDataRanges = append(splitDataRanges, DataRange{
					Min: mapRange.Min + mapRange.Offset,
					Max: dataRange.Max + mapRange.Offset,
				})
				dataRange.Max = mapRange.Min - 1
				continue
			}
			if dataRange.IsOverlappingMapRangeEnd(mapRange) {
				splitDataRanges = append(splitDataRanges, DataRange{
					Min: dataRange.Min + mapRange.Offset,
					Max: mapRange.Max + mapRange.Offset,
				})
				dataRange.Min = mapRange.Max + 1
				continue
			}
		}
		splitDataRanges = append(splitDataRanges, dataRange)
	}
	return splitDataRanges
}

func (dr DataRange) IsOutsideMapRange(mr MapRange) bool {
	return dr.Max < mr.Min || dr.Min > mr.Max
}

func (dr DataRange) IsInsideMapRange(mr MapRange) bool {
	return dr.Min >= mr.Min && dr.Max <= mr.Max
}

func (dr DataRange) IsOverlappingMapRangeStart(mr MapRange) bool {
	return dr.Min < mr.Min && dr.Max >= mr.Min && dr.Max <= mr.Max
}

func (dr DataRange) IsOverlappingMapRangeEnd(mr MapRange) bool {
	return dr.Min >= mr.Min && dr.Min <= mr.Max && dr.Max > mr.Max
}

func Two(input string) string {
	sections := strings.Split(input, "\n\n")
	seedRanges := parseSeedRanges(sections[0])
	mapBlocks := make(map[string]MapBlock)
	for _, mapBlockString := range sections[1:] {
		mapSource, mapBlock := parseMapBlock(mapBlockString)
		mapBlocks[mapSource] = mapBlock
	}

	for mapBlock := mapBlocks["seed"]; mapBlock.DestinationName != "location"; mapBlock = mapBlocks[mapBlock.DestinationName] {
		seedRanges = mapBlock.ApplyMapToRanges(seedRanges)
	}
	minimumDistance := 0
	for _, location := range seedRanges {
		if minimumDistance == 0 || location.Min < minimumDistance {
			minimumDistance = location.Min
		}
	}
	return strconv.Itoa(minimumDistance)
}

func parseSeedRanges(line string) []DataRange {
	parsedNumbers := parseSeeds(line)
	var seedRanges []DataRange
	for i := 0; i < len(parsedNumbers); i += 2 {
		seedRanges = append(seedRanges, DataRange{
			Min: parsedNumbers[i],
			Max: parsedNumbers[i] + parsedNumbers[i+1],
		})
	}
	return seedRanges
}
