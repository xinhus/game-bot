<?php

namespace GameBot\TicTacToe\Map;


class DefaultMap {

    private $map;

    public function __construct(array $map)
    {
        self::validateMapStructure($map);
        $this->map = $map;
    }

    private static function validateMapStructure(array $map): void
    {
        self::validateThereIsOnlyThreeIndex($map, 'Invalid map structure, the map should have 3 rows');

        foreach ($map as $row) {
            self::validateThereIsOnlyThreeIndex($row, 'Invalid map structure, the map should have 3 columns');
        }
    }

    private static function validateThereIsOnlyThreeIndex(array $map, string $message): void
    {
        if (sizeof($map) != 3) {
            throw new \InvalidArgumentException($message);
        }
    }

    /**
     * @return MapPosition[]
     */
    public function getEmptySpots(): array
    {
        $emptySpots = [];
        for ($x = 0; $x < 3; $x++) {
            for ($y = 0; $y < 3; $y++) {
                if (empty($this->map[$y][$x])) {
                    array_push($emptySpots, new MapPosition($x, $y));
                }
            }
        }
        return $emptySpots;
    }

    public function simulateMapWithNextMove(MapPosition $move, string $player): DefaultMap
    {
        $map = $this->map;
        $map[$move->getY()][$move->getX()] = $player;
        return new self($map);
    }

    public function hasWinner(): bool
    {
        return !empty($this->getWinnerPlayer());
    }

    public function isTie(): bool
    {
        if ($this->hasWinner()) {
            return false;
        }
        foreach ($this->map as $columns) {
            foreach ($columns as $slot) {
                if (empty($slot)) {
                    return false;
                }
            }
        }
        return true;
    }

    public function getWinnerPlayer(): ?string
    {
        $map = $this->map;
        if (
            (!empty($map[0][0]) && $map[0][0] == $map[0][1] && $map[0][1] == $map[0][2]) || //first row
            (!empty($map[0][0]) && $map[0][0] == $map[1][0] && $map[1][0] == $map[2][0]) || //first column
            (!empty($map[0][0]) && $map[0][0] == $map[1][1] && $map[1][1] == $map[2][2]) //first diagonal
        )
            return $map[0][0];

        if (!empty($map[1][0]) && $map[1][0] == $map[1][1] && $map[1][1] == $map[1][2]) //second column
            return $map[1][0];

        if (!empty($map[2][0]) && $map[2][0] == $map[2][1] && $map[2][1] == $map[2][2]) //third column
            return $map[2][0];

        if (!empty($map[0][1]) && $map[0][1] == $map[1][1] && $map[1][1] == $map[2][1]) //second row
            return $map[0][1];

        if (
            (!empty($map[0][2]) && $map[0][2] == $map[1][2] && $map[1][2] == $map[2][2]) || //third row
            (!empty($map[0][2]) && $map[0][2] == $map[1][1] && $map[1][1] == $map[2][0]) //second diagonal
        )
            return $map[0][2];

        return null;
    }
}
