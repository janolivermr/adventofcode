package day10

import (
	"strconv"
	"strings"
)

func (t Tile) isInsidePath(path map[TileIndex]rune, height int, width int) bool {
	crossingsTowardsNorth := 0
	for y := 0; y < t.Y; y++ {
		tileType, ok := path[calculateTileIndex(t.X, y)]
		if ok && (tileType == '-' || tileType == 'F' || tileType == 'L') {
			crossingsTowardsNorth++
		}
	}
	crossingsTowardsWest := 0
	for x := 0; x < t.X; x++ {
		tileType, ok := path[calculateTileIndex(x, t.Y)]
		if ok && (tileType == '|' || tileType == 'F' || tileType == '7') {
			crossingsTowardsWest++
		}
	}
	crossingsTowardsSouth := 0
	for y := t.Y + 1; y < height; y++ {
		tileType, ok := path[calculateTileIndex(t.X, y)]
		if ok && (tileType == '-' || tileType == 'F' || tileType == 'L') {
			crossingsTowardsSouth++
		}
	}
	crossingsTowardsEast := 0
	for x := t.X + 1; x < width; x++ {
		tileType, ok := path[calculateTileIndex(x, t.Y)]
		if ok && (tileType == '|' || tileType == 'F' || tileType == '7') {
			crossingsTowardsEast++
		}
	}
	if crossingsTowardsNorth%2 == 1 && crossingsTowardsWest%2 == 1 && crossingsTowardsSouth%2 == 1 && crossingsTowardsEast%2 == 1 {
		return true
	}
	return false
}

func (t Tile) findType(path map[TileIndex]rune) rune {
	if t.Type != 'S' {
		panic("not a start tile")
	}
	northTileExists := false
	if _, ok := path[t.North]; ok {
		northTileExists = true
	}
	westTileExists := false
	if _, ok := path[t.West]; ok {
		westTileExists = true
	}
	southTileExists := false
	if _, ok := path[t.South]; ok {
		southTileExists = true
	}
	eastTileExists := false
	if _, ok := path[t.East]; ok {
		eastTileExists = true
	}

	if northTileExists && southTileExists {
		return '|'
	} else if westTileExists && eastTileExists {
		return '-'
	} else if northTileExists && westTileExists {
		return 'J'
	} else if westTileExists && southTileExists {
		return '7'
	} else if southTileExists && eastTileExists {
		return 'F'
	} else if eastTileExists && northTileExists {
		return 'L'
	}
	panic("failed to calculate start tile type")
}

func Two(input string) string {
	lines := strings.Split(strings.TrimSpace(input), "\n")
	tiles := make(map[TileIndex]Tile)
	var startTileIndex TileIndex
	for row, line := range lines {
		chars := []rune(line)
		for col, char := range chars {
			tiles[calculateTileIndex(col, row)] = parseTile(char, col, row)
			if char == 'S' {
				startTileIndex = calculateTileIndex(col, row)
			}
		}
	}
	stepsToTile := make(map[TileIndex]int)
	stepsToTile[startTileIndex] = 0
	path := make(map[TileIndex]rune)
	for _, cardinal := range []TileIndex{tiles[startTileIndex].North, tiles[startTileIndex].West, tiles[startTileIndex].South, tiles[startTileIndex].East} {
		var visitedTiles []TileIndex
		visitedTiles = append(visitedTiles, startTileIndex)
		for previousTile, currentTile := startTileIndex, cardinal; currentTile != EmptyTileIndex; previousTile, currentTile = tiles[currentTile].walkTile(previousTile) {
			if currentTile == startTileIndex {
				for _, tile := range visitedTiles {
					path[tile] = tiles[tile].Type
				}
				break
			}
			stepsToTile[currentTile] = len(visitedTiles)
			visitedTiles = append(visitedTiles, currentTile)
		}
		if len(path) > 0 {
			break
		}
	}
	path[startTileIndex] = tiles[startTileIndex].findType(path)
	height := len(lines)
	width := len(lines[0])
	insideTiles := 0
	for tileIndex, tile := range tiles {
		if _, ok := path[tileIndex]; ok {
			continue
		}
		if tile.isInsidePath(path, height, width) {
			insideTiles++
		}
	}
	return strconv.Itoa(insideTiles)
}
