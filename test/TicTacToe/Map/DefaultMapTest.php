<?php

namespace Test\GameBot\TicTacToe\Map;


use GameBot\TicTacToe\Map\DefaultMap;
use GameBot\TicTacToe\Map\MapPosition;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class DefaultMapTest extends TestCase {

    public function getMapsToTestEmptySpots(): array
    {
        return [
            [
                'map' => [
                    ['X', 'O', 'X'],
                    ['O', 'X', 'O'],
                    ['X', 'O', 'X'],
                ],
                'emptySpot' => []
            ],
            [
                'map' => [
                    ['X', 'O', 'X'],
                    ['O', 'X', 'O'],
                    ['X', 'O', ''],
                ],
                'emptySpot' => [new MapPosition(2, 2)]
            ],
            [
                'map' => [
                    ['', '', ''],
                    ['X', 'O', 'X'],
                    ['O', 'X', 'O'],
                ],
                'emptySpot' => [new MapPosition(0,0), new MapPosition(1, 0), new MapPosition(2, 0)]
            ],
            [
                'map' => [
                    ['X', 'O', 'X'],
                    ['', '', ''],
                    ['O', 'X', 'O'],
                ],
                'emptySpot' => [new MapPosition(0,1), new MapPosition(1, 1), new MapPosition(2, 1)]
            ],
            [
                'map' => [
                    ['X', 'O', 'X'],
                    ['O', 'X', 'O'],
                    ['', '', ''],
                ],
                'emptySpot' => [new MapPosition(0,2), new MapPosition(1, 2), new MapPosition(2, 2)]
            ],
            [
                'map' => [
                    ['', '', ''],
                    ['', '', ''],
                    ['', '', ''],
                ],
                'emptySpot' => [

                    new MapPosition(0,0), new MapPosition(0, 1), new MapPosition(0, 2),
                    new MapPosition(1,0), new MapPosition(1, 1), new MapPosition(1, 2),
                    new MapPosition(2,0), new MapPosition(2, 1), new MapPosition(2, 2),
                ]
            ],
        ];
    }

    /**
     * @dataProvider getMapsToTestEmptySpots
     * @param array $mapToTest
     * @param array $expectedSpots
     */
    public function testEmptySpots(array $mapToTest, array $expectedSpots): void
    {
        $map = new DefaultMap($mapToTest);
        $result = $map->getEmptySpots();
        Assert::assertEquals($expectedSpots, $result);
    }

    public function getInvalidMapsToTest(): array
    {
        return [
            [
                'map' => [
                    ['', ''],
                    ['', ''],
                    ['', ''],
                ],
                'expectedMessage' => 'Invalid map structure, the map should have 3 columns'
            ],
            [
                'map' => [
                    ['', '', ''],
                    ['', '', ''],
                ],
                'expectedMessage' => 'Invalid map structure, the map should have 3 rows'
            ],
        ];
    }

    /**
     * @dataProvider getInvalidMapsToTest
     * @param array $mapToTest
     */
    public function testMapConsistency(array $mapToTest, string $expected_message): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expected_message);
        $map = new DefaultMap($mapToTest);
    }
}