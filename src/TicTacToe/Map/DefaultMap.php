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
}
