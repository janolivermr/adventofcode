package day10

import (
	"strconv"
	"strings"
)

type Tile struct {
	Type  rune
	X     int
	Y     int
	North TileIndex
	West  TileIndex
	South TileIndex
	East  TileIndex
}

func (t Tile) walkTile(origin TileIndex) (TileIndex, TileIndex) {
	tileCanBeReached := false
	for _, tileIndex := range []TileIndex{t.North, t.West, t.South, t.East} {
		if tileIndex == origin {
			tileCanBeReached = true
		}
	}
	if !tileCanBeReached {
		//fmt.Printf("tile %v can't be reached from %v\n", calculateTileIndex(t.X, t.Y), origin)
		return origin, EmptyTileIndex
	}
	for _, tileIndex := range []TileIndex{t.North, t.West, t.South, t.East} {
		if tileIndex != EmptyTileIndex && tileIndex != origin {
			//fmt.Printf("tile %v reached from %v\n", calculateTileIndex(t.X, t.Y), origin)
			return calculateTileIndex(t.X, t.Y), tileIndex
		}
	}
	return origin, EmptyTileIndex
}

type TileIndex string

const EmptyTileIndex TileIndex = ""

func One(input string) string {
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
	var farthestSteps int
	for _, cardinal := range []TileIndex{tiles[startTileIndex].North, tiles[startTileIndex].West, tiles[startTileIndex].South, tiles[startTileIndex].East} {
		stepCounter := 1
		for previousTile, currentTile := startTileIndex, cardinal; currentTile != EmptyTileIndex && currentTile != startTileIndex; previousTile, currentTile = tiles[currentTile].walkTile(previousTile) {
			if tileVisitedInFewerSteps(currentTile, stepCounter, stepsToTile) {
				farthestSteps = stepCounter
				break
			}
			stepsToTile[currentTile] = stepCounter
			stepCounter++
		}
	}
	return strconv.Itoa(farthestSteps)
}

func tileVisitedInFewerSteps(tileIndex TileIndex, steps int, visitedTiles map[TileIndex]int) bool {
	visitedSteps, ok := visitedTiles[tileIndex]
	if ok && visitedSteps <= steps {
		//fmt.Printf("tile %s already visited in %d steps, tried %d\n", tileIndex, visitedSteps, steps)
		return true
	}
	return false
}

func parseTile(char rune, col int, row int) Tile {
	tile := Tile{
		Type:  char,
		X:     col,
		Y:     row,
		North: calculateTileIndex(col, row-1),
		West:  calculateTileIndex(col-1, row),
		South: calculateTileIndex(col, row+1),
		East:  calculateTileIndex(col+1, row),
	}
	switch char {
	case '|':
		tile.West = EmptyTileIndex
		tile.East = EmptyTileIndex
	case '-':
		tile.North = EmptyTileIndex
		tile.South = EmptyTileIndex
	case 'L':
		tile.West = EmptyTileIndex
		tile.South = EmptyTileIndex
	case 'J':
		tile.South = EmptyTileIndex
		tile.East = EmptyTileIndex
	case '7':
		tile.North = EmptyTileIndex
		tile.East = EmptyTileIndex
	case 'F':
		tile.North = EmptyTileIndex
		tile.West = EmptyTileIndex
	case '.':
		tile.North = EmptyTileIndex
		tile.West = EmptyTileIndex
		tile.South = EmptyTileIndex
		tile.East = EmptyTileIndex
	}
	return tile
}

func calculateTileIndex(x int, y int) TileIndex {
	if x < 0 || y < 0 {
		return ""
	}
	return TileIndex("x" + strconv.Itoa(x) + "y" + strconv.Itoa(y))
}
