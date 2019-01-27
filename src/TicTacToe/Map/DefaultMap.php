<?php

namespace GameBot\TicTacToe\Map;

use GameBot\TicTacToe\Exceptions\NoMorePossibleMovementsException;

class DefaultMap {

    private $map;

    public function __construct(array $map)
    {
        self::validateMapStructure($map);
        self::validateWinner($map);
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

    private static function validateWinner(array $map)
    {
        if (
            (!empty($map[0][0]) && $map[0][0] == $map[0][1] && $map[0][1] == $map[0][2]) || //first row
            (!empty($map[0][0]) && $map[0][0] == $map[1][0] && $map[1][0] == $map[2][0]) || //first column
            (!empty($map[0][0]) && $map[0][0] == $map[1][1] && $map[1][1] == $map[2][2]) //first diagonal
        )
            throw new NoMorePossibleMovementsException("The player \"{$map[0][0]}\" already won the game.");

        if (!empty($map[1][0]) && $map[1][0] == $map[1][1] && $map[1][1] == $map[1][2]) //second column
            throw new NoMorePossibleMovementsException("The player \"{$map[1][0]}\" already won the game.");

        if (!empty($map[2][0]) && $map[2][0] == $map[2][1] && $map[2][1] == $map[2][2]) //third column
            throw new NoMorePossibleMovementsException("The player \"{$map[2][0]}\" already won the game.");

        if (!empty($map[0][1]) && $map[0][1] == $map[1][1] && $map[1][1] == $map[2][1]) //second row
            throw new NoMorePossibleMovementsException("The player \"{$map[0][1]}\" already won the game.");

        if (
            (!empty($map[0][2]) && $map[0][2] == $map[1][2] && $map[1][2] == $map[2][2]) || //third row
            (!empty($map[0][2]) && $map[0][2] == $map[1][1] && $map[1][1] == $map[2][0]) //second diagonal
        )
            throw new NoMorePossibleMovementsException("The player \"{$map[0][2]}\" already won the game.");

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
